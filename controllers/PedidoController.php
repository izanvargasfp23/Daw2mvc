<?php
include_once("models/DAOs/PedidoDAO.php");
include_once("models/DAOs/UsuarioDAO.php");

class PedidoController
{
    public function confirmar()
    {
        // si el carrito esta vacio, volvemos a la cesta
        if (empty($_SESSION['carrito'])) {
            header("Location: index.php?controller=Carrito&action=index");
            exit();
        }

        // si no ha iniciado sesion, lo mandamos al login y recordamos que venia de pagar
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['volver_a_pedido'] = true;
            header("Location: index.php?controller=Usuario&action=login");
            exit();
        }

        // calculamos el subtotal del carrito
        $subtotal = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $subtotal = $subtotal + ($item['precio'] * $item['cantidad']);
        }

        $envio = 3.00;
        $descuento = 0;
        $codigoCupon = "";
        $mensajeCupon = "";
        $errorFormulario = "";

        // sacamos los datos del usuario de la base de datos para rellenar el formulario
        $usuario = UsuarioDAO::buscarPorEmail($_SESSION['usuario_email']);

        $email = "";
        if (isset($usuario['email'])) {
            $email = $usuario['email'];
        }

        $nombre = "";
        if (isset($usuario['nombre'])) {
            $nombre = $usuario['nombre'];
        }

        $direccion = "";
        if (isset($usuario['direccion'])) {
            $direccion = $usuario['direccion'];
        }

        $telefono = "";
        if (isset($usuario['telefono'])) {
            $telefono = $usuario['telefono'];
        }

        $apellido = "";
        $edificio = "";
        $cp = "";
        $ciudad = "";
        $pais = "España";
        $metodoPago = "Tarjeta de crédito o débito";
        $numTarjeta = "";
        $caducidad = "";
        $cvv = "";

        if ($_POST) {
            if (isset($_POST['email'])) $email = trim($_POST['email']);
            if (isset($_POST['pais'])) $pais = $_POST['pais'];
            if (isset($_POST['nombre'])) $nombre = trim($_POST['nombre']);
            if (isset($_POST['apellido'])) $apellido = trim($_POST['apellido']);
            if (isset($_POST['direccion'])) $direccion = trim($_POST['direccion']);
            if (isset($_POST['edificio'])) $edificio = trim($_POST['edificio']);
            if (isset($_POST['cp'])) $cp = trim($_POST['cp']);
            if (isset($_POST['ciudad'])) $ciudad = trim($_POST['ciudad']);
            if (isset($_POST['telefono'])) $telefono = trim($_POST['telefono']);
            if (isset($_POST['metodo_pago'])) $metodoPago = $_POST['metodo_pago'];
            if (isset($_POST['num_tarjeta'])) $numTarjeta = trim($_POST['num_tarjeta']);
            if (isset($_POST['caducidad'])) $caducidad = trim($_POST['caducidad']);
            if (isset($_POST['cvv'])) $cvv = trim($_POST['cvv']);
            if (isset($_POST['codigo_cupon'])) $codigoCupon = trim($_POST['codigo_cupon']);

            // miramos si ha puesto un codigo de descuento
            if ($codigoCupon != "") {
                $oferta = PedidoDAO::buscarCupon($codigoCupon);
                if ($oferta) {
                    $descuento = ($subtotal * $oferta['valor']) / 100;
                    $mensajeCupon = "Cupón aplicado: -" . number_format($descuento, 2, ',', '.') . "€";
                } else {
                    $mensajeCupon = "El código no es válido o ha caducado.";
                }
            }

            // si ha pulsado el boton de pagar ahora
            if (isset($_POST['pagar_ahora'])) {
                if ($email == "" || $nombre == "" || $direccion == "" || $cp == "" || $ciudad == "") {
                    $errorFormulario = "Por favor, rellena los datos obligatorios de contacto y entrega.";
                } else {
                    $total = ($subtotal - $descuento) + $envio;
                    if ($total < 0) {
                        $total = 0;
                    }

                    $idUser = $_SESSION['usuario_id'];
                    $emailUser = $_SESSION['usuario_email'];

                    // juntamos la direccion completa para guardarla en el perfil del usuario
                    $direccionCompleta = $direccion . ", " . $cp . " " . $ciudad;
                    UsuarioDAO::actualizarDatosEnvio($idUser, $telefono, $direccionCompleta);

                    // guardamos el pedido en la base de datos
                    $pedidoId = PedidoDAO::guardarPedido($idUser, $subtotal, $descuento, $total, $metodoPago, $_SESSION['carrito']);

                    // calculamos los puntos VP exactos segun los productos y menus del carrito
                    $puntosGanados = 0;

                    foreach ($_SESSION['carrito'] as $item) {
                        $cantidad = intval($item['cantidad']);

                        if (isset($item['tipo']) && $item['tipo'] == 'menu') {
                            // los menus dan sus VPOINTS exactos (4350, 3600, 3950)
                            $vpItem = intval(round($item['precio'] * 100));
                            $puntosGanados = $puntosGanados + ($vpItem * $cantidad);
                        } else {
                            // los platos dan segun su categoria (bebidas = 0)
                            $catId = 0;
                            if (isset($item['categoria_id'])) {
                                $catId = intval($item['categoria_id']);
                            }

                            $vpCategoria = 0;
                            if ($catId == 1) {
                                $vpCategoria = 500;  // Entrantes
                            } elseif ($catId == 2) {
                                $vpCategoria = 1000; // Primeros
                            } elseif ($catId == 3) {
                                $vpCategoria = 2000; // Segundos
                            } elseif ($catId == 4) {
                                $vpCategoria = 500;  // Postres
                            }

                            $puntosGanados = $puntosGanados + ($vpCategoria * $cantidad);
                        }
                    }

                    UsuarioDAO::sumarPuntos($idUser, $puntosGanados);
                    $_SESSION['ultimos_puntos_ganados'] = $puntosGanados;

                    // vaciamos el carrito porque ya esta pagado
                    $_SESSION['carrito'] = [];
                    $_SESSION['carritos_usuarios'][$emailUser] = [];
                    $_SESSION['ultimo_pedido_id'] = $pedidoId;

                    header("Location: index.php?controller=Pedido&action=completado");
                    exit();
                }
            }
        }

        $total = ($subtotal - $descuento) + $envio;
        if ($total < 0) {
            $total = 0;
        }

        $view = "views/proceso_compra.php";
        include_once("views/main.php");
    }

    // enseña la pantalla de pedido confirmado
    public function completado()
    {
        $view = "views/pedido_completado.php";
        include_once("views/main.php");
    }
}