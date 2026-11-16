<?php
include_once("models/DAOs/ProductoDAO.php");
include_once("models/DAOs/MenuDAO.php");

class CarritoController
{
    // guarda el carrito dentro de la carpeta del usuario si tiene sesion iniciada
    private function guardarCarritoEnUsuario()
    {
        if (isset($_SESSION['usuario_email'])) {
            $emailUser = $_SESSION['usuario_email'];
            $_SESSION['carritos_usuarios'][$emailUser] = $_SESSION['carrito'];
        }
    }

    // mostrar la vista de la cesta
    public function index()
    {
        if (!isset($_SESSION['carrito'])) {$_SESSION['carrito'] = [];
        }

        $view = "views/carrito.php";
        include_once("views/main.php");
    }

    // añadir producto desde detalle.php
    public function add()
    {
        if (!isset($_SESSION['carrito'])) {$_SESSION['carrito'] = [];
        }

        // 1. si viene de añadir un menu
        if (isset($_GET['type']) &&$_GET['type'] == 'menu' && isset($_GET['id'])) {$menuId = intval($_GET['id']);$listaMenus = MenuDAO::getAllWithPlatos();

            if (isset($listaMenus[$menuId])) {
                $menu =$listaMenus[$menuId];$encontrado = false;

                foreach ($_SESSION['carrito'] as $i =>$item) {
                    if (isset($item['tipo']) &&$item['tipo'] == 'menu' && $item['id'] ==$menuId) {
                        $_SESSION['carrito'][$i]['cantidad'] = $_SESSION['carrito'][$i]['cantidad'] + 1;
                        $encontrado = true;
                        break;
                    }
                }

                if ($encontrado == false) {$_SESSION['carrito'][] = [
                        'tipo' => 'menu',
                        'id' => $menu['id'],
                        'nombre' => 'MENÚ ' . $menu['nombre'],
                        'precio' => $menu['precio'],
                        'imagen' => $menu['imagen'],
                        'cantidad' => 1,
                        'platos' => $menu['platos'],
                        'ingredientes' => []
                    ];
                }
            }

            $this->guardarCarritoEnUsuario();
            header("Location: index.php?controller=Carrito&action=index");
            exit;
        }

        // 2. si viene de añadir o editar un producto
        if (isset($_POST['producto_id'])) {$id = intval($_POST['producto_id']);$cantidad = 1;
            if (isset($_POST['cantidad'])) {
                $cantidad = intval($_POST['cantidad']);
            }
            $ingredientes = [];
            if (isset($_POST['ingredientes'])) {
                $ingredientes =$_POST['ingredientes'];
            }

            $producto = ProductoDAO::getById($id);

            if ($producto != null) {
                // si venia de editar, actualizamos esa linea
                if (isset($_POST['edit_index']) && isset($_SESSION['carrito'][$_POST['edit_index']])) {$idx = intval($_POST['edit_index']);$_SESSION['carrito'][$idx]['cantidad'] =$cantidad;
                    $_SESSION['carrito'][$idx]['ingredientes'] =$ingredientes;
                } else {
                    // si es nuevo, miramos si ya estaba igual en la cesta
                    $encontrado = false;
                    foreach ($_SESSION['carrito'] as$i => $item) {$esProducto = false;
                        if (!isset($item['tipo']) || $item['tipo'] == 'producto') {$esProducto = true;
                        }

                        if ($esProducto &&$item['id'] == $id &&$item['ingredientes'] == $ingredientes) {$_SESSION['carrito'][$i]['cantidad'] =$_SESSION['carrito'][$i]['cantidad'] +$cantidad;
                            $encontrado = true;
                            break;
                        }
                    }

                    if ($encontrado == false) {$_SESSION['carrito'][] = [
                            'tipo' => 'producto',
                            'id' => $producto->getId(),
                            'nombre' => $producto->getNombre(),
                            'precio' => $producto->getPrecio(),
                            'imagen' => $producto->getImagen(),
                            'categoria_id' => $producto->getCategoriaId(),
                            'cantidad' => $cantidad,
                            'platos' => [],
                            'ingredientes' => $ingredientes
                        ];
                    }
                }
            }
        }

        $this->guardarCarritoEnUsuario();
        header("Location: index.php?controller=Carrito&action=index");
        exit;
    }

    // sumar 1 desde la cesta
    public function sumar()
    {
        if (isset($_GET['id']) && isset($_SESSION['carrito'][$_GET['id']])) {
            $i =$_GET['id'];
            $_SESSION['carrito'][$i]['cantidad'] = $_SESSION['carrito'][$i]['cantidad'] + 1;
            $this->guardarCarritoEnUsuario();
        }

        header("Location: index.php?controller=Carrito&action=index");
        exit;
    }

    // restar 1 desde la cesta
    public function restar()
    {
        if (isset($_GET['id']) && isset($_SESSION['carrito'][$_GET['id']])) {
            $i =$_GET['id'];
            $_SESSION['carrito'][$i]['cantidad'] = $_SESSION['carrito'][$i]['cantidad'] - 1;

            if ($_SESSION['carrito'][$i]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$i]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            }
            $this->guardarCarritoEnUsuario();
        }

        header("Location: index.php?controller=Carrito&action=index");
        exit;
    }

    // eliminar una linea entera
    public function eliminar()
    {
        if (isset($_GET['id']) && isset($_SESSION['carrito'][$_GET['id']])) {
            unset($_SESSION['carrito'][$_GET['id']]);$_SESSION['carrito'] = array_values($_SESSION['carrito']);$this->guardarCarritoEnUsuario();
        }

        header("Location: index.php?controller=Carrito&action=index");
        exit;
    }
}