<?php
include_once("models/DAOs/UsuarioDAO.php");
include_once("models/DAOs/PedidoDAO.php");

class UsuarioController
{
    // recupera el carrito del usuario por su correo y le suma lo que hubiera metido antes de entrar
    private function ponerCarritoDelUsuario($emailUser)
    {
        $carritoGuardado = [];
        if (isset($_SESSION['carritos_usuarios'][$emailUser])) {
            $carritoGuardado = $_SESSION['carritos_usuarios'][$emailUser];
        }

        $carritoSinCuenta = [];
        if (isset($_SESSION['carrito'])) {
            $carritoSinCuenta = $_SESSION['carrito'];
        }

        foreach ($carritoSinCuenta as $itemNuevo) {
            $yaEstaba = false;

            foreach ($carritoGuardado as $i => $itemViejo) {
                $tipoViejo = 'producto';
                if (isset($itemViejo['tipo'])) {
                    $tipoViejo = $itemViejo['tipo'];
                }

                $tipoNuevo = 'producto';
                if (isset($itemNuevo['tipo'])) {
                    $tipoNuevo = $itemNuevo['tipo'];
                }

                if ($tipoViejo == $tipoNuevo && $itemViejo['id'] == $itemNuevo['id'] && $itemViejo['ingredientes'] == $itemNuevo['ingredientes']) {
                    $carritoGuardado[$i]['cantidad'] = $carritoGuardado[$i]['cantidad'] + $itemNuevo['cantidad'];
                    $yaEstaba = true;
                    break;
                }
            }

            if ($yaEstaba == false) {
                $carritoGuardado[] = $itemNuevo;
            }
        }

        $_SESSION['carrito'] = $carritoGuardado;
        $_SESSION['carritos_usuarios'][$emailUser] = $carritoGuardado;
    }

    // enseña el formulario de login y comprueba los datos
    public function login()
    {
        $error = "";
        $email = "";

        if ($_POST) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if ($email == "" || $password == "") {
                $error = "Rellena todos los campos.";
            } else {
                $usuario = UsuarioDAO::buscarPorEmail($email);

                if ($usuario && password_verify($password, $usuario['password'])) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    $_SESSION['usuario_rol'] = $usuario['rol'];

                    // cargamos el carrito propio de este usuario
                    $this->ponerCarritoDelUsuario($usuario['email']);

                    if (isset($_SESSION['volver_a_pedido']) && $_SESSION['volver_a_pedido'] == true) {
                        unset($_SESSION['volver_a_pedido']);
                        header("Location: index.php?controller=Pedido&action=confirmar");
                        exit();
                    }

                    header("Location: index.php?controller=Producto&action=carta");
                    exit();
                } else {
                    $error = "El correo o la contraseña no son correctos.";
                }
            }
        }

        $view = "views/login.php";
        include_once("views/main.php");
    }

    // enseña el formulario de registro y crea la cuenta
    public function registro()
    {
        $error = "";
        $nombre = "";
        $email = "";

        if ($_POST) {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if ($nombre == "" || $email == "" || $password == "") {
                $error = "Rellena todos los campos.";
            } else {
                $existe = UsuarioDAO::buscarPorEmail($email);

                if ($existe) {
                    $error = "Ese correo ya está registrado.";
                } else {
                    $ok = UsuarioDAO::registrar($nombre, $email, $password);

                    if ($ok) {
                        $usuarioNuevo = UsuarioDAO::buscarPorEmail($email);
                        $_SESSION['usuario_id'] = $usuarioNuevo['id'];
                        $_SESSION['usuario_nombre'] = $usuarioNuevo['nombre'];
                        $_SESSION['usuario_email'] = $usuarioNuevo['email'];
                        $_SESSION['usuario_rol'] = $usuarioNuevo['rol'];

                        // vinculamos el carrito actual a este usuario
                        $this->ponerCarritoDelUsuario($usuarioNuevo['email']);

                        if (isset($_SESSION['volver_a_pedido']) && $_SESSION['volver_a_pedido'] == true) {
                            unset($_SESSION['volver_a_pedido']);
                            header("Location: index.php?controller=Pedido&action=confirmar");
                            exit();
                        }

                        header("Location: index.php?controller=Producto&action=carta");
                        exit();
                    } else {
                        $error = "Hubo un error al crear la cuenta.";
                    }
                }
            }
        }

        $view = "views/registro.php";
        include_once("views/main.php");
    }

    // cierra la sesion del usuario y limpia el carrito visible
    public function logout()
    {
        // guardamos su carrito antes de salir para cuando vuelva a entrar
        if (isset($_SESSION['usuario_email'])) {
            $emailUser = $_SESSION['usuario_email'];
            if (isset($_SESSION['carrito'])) {
                $_SESSION['carritos_usuarios'][$emailUser] = $_SESSION['carrito'];
            } else {
                $_SESSION['carritos_usuarios'][$emailUser] = [];
            }
        }

        // vaciamos el carrito de la pantalla
        $_SESSION['carrito'] = [];

        unset($_SESSION['usuario_id']);
        unset($_SESSION['usuario_nombre']);
        unset($_SESSION['usuario_email']);
        unset($_SESSION['usuario_rol']);

        header("Location: index.php?controller=Producto&action=carta");
        exit();
    }

    // enseña el panel de usuario con sus datos, puntos VP, ofertas y pedidos
    public function perfil()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }

        $idUser = $_SESSION['usuario_id'];
        $usuario = UsuarioDAO::buscarPorEmail($_SESSION['usuario_email']);
        $pedidos = PedidoDAO::obtenerPedidosPorUsuario($idUser);
        $ofertasDisponibles = UsuarioDAO::obtenerOfertasDisponibles();
        $ofertasCanjeadas = UsuarioDAO::obtenerOfertasCanjeadas($idUser);

        $mensajeCanje = "";
        if (isset($_SESSION['mensaje_canje'])) {
            $mensajeCanje = $_SESSION['mensaje_canje'];
            unset($_SESSION['mensaje_canje']);
        }

        $view = "views/perfil.php";
        include_once("views/main.php");
    }

    // canjea una oferta gastando puntos VP
    public function canjear()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }

        if (isset($_GET['id'])) {
            $ofertaId = intval($_GET['id']);
            $idUser = $_SESSION['usuario_id'];

            $ok = UsuarioDAO::canjearOferta($idUser, $ofertaId);

            if ($ok) {
                $_SESSION['mensaje_canje'] = "¡Oferta canjeada! Ya tienes tu código listo para usar en el carrito.";
            } else {
                $_SESSION['mensaje_canje'] = "No tienes suficientes puntos VP para canjear esta oferta.";
            }
        }

        header("Location: index.php?controller=Usuario&action=perfil");
        exit();
    }
}