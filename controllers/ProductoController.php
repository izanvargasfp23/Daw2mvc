<?php
include_once("models/DAOs/ProductoDAO.php");
include_once("models/DAOs/IngredienteDAO.php");
include_once("models/DAOs/AlergenoDAO.php");

class ProductoController
{
    public function carta()
    {
        // 1. Obtener los productos desde el DAO
        $productos = ProductoDAO::getAll();

        if (!isset($productos)) {
            $productos = [];
        }

        // 2. Definir la vista interna y llamar a la plantilla principal
        $view = "views/carta.php";
        include_once("views/main.php");
    }

    public function chefs() {
        // Redirige directamente al ancla #chefs de la página principal
        header("Location: index.php?controller=Home&action=index#chefs");
        exit();
    }

    public function menus() {
       require_once 'models/DAOs/MenuDAO.php';
       $lista_menus = MenuDAO::getAllWithPlatos();
        
        // 2. Definir la vista interna y llamar a la plantilla principal
        $view = "views/menus.php";
        include_once("views/main.php");
    }

    public function detalle() {
        // Asigna el id si existe, pero si no existe deja el 1 como default 
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 1;
        }

        // Obtenemos el producto, sus ingredientes y alérgenos directamente
        $producto = ProductoDAO::getById($id);
        $ingredientes = IngredienteDAO::getByProductoId($id);
        $alergenos = AlergenoDAO::getByProductoId($id);

        // valores por defecto si vienes de la carta
        $cantidadActual = 1;
        $editIndex = null;

        // si venimos de darle a EDITAR en el carrito, cargamos lo que ya habia
        if (isset($_GET['edit'])) {
            $editIndex = $_GET['edit'];
            if (isset($_SESSION['carrito'][$editIndex])) {
                $cantidadActual = $_SESSION['carrito'][$editIndex]['cantidad'];
                $ingredientes = $_SESSION['carrito'][$editIndex]['ingredientes'];
            }
        }

        // si hemos pulsado algun boton del formulario (sumar, restar o añadir)
        if ($_POST) {
            
            // guardamos lo que ya estaba puesto en el formulario
            if (isset($_POST['cantidad'])) {
                $cantidadActual = $_POST['cantidad'];
            }
            if (isset($_POST['edit_index'])) {
                $editIndex = $_POST['edit_index'];
            }
            if (isset($_POST['ingredientes'])) {
                $ingredientes = $_POST['ingredientes'];
            }

            // si le dio al + del producto
            if (isset($_POST['sumar_prod'])) {
                $cantidadActual = $cantidadActual + 1;
            }

            // si le dio al - del producto (que no baje de 1)
            if (isset($_POST['restar_prod'])) {
                if ($cantidadActual > 1) {
                    $cantidadActual = $cantidadActual - 1;
                }
            }

            // si le dio al + de algun ingrediente (tope 5)
            if (isset($_POST['sumar_ing'])) {
                $pos = $_POST['sumar_ing'];
                if ($ingredientes[$pos]['cantidad'] < 5) {
                    $ingredientes[$pos]['cantidad'] = $ingredientes[$pos]['cantidad'] + 1;
                }
            }

            // si le dio al - de algun ingrediente (tope 0)
            if (isset($_POST['restar_ing'])) {
                $pos = $_POST['restar_ing'];
                if ($ingredientes[$pos]['cantidad'] > 0) {
                    $ingredientes[$pos]['cantidad'] = $ingredientes[$pos]['cantidad'] - 1;
                }
            }

            // si le dio al boton rojo de AÑADIR AL CARRITO
            if (isset($_POST['anadir_carrito'])) {
                
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }

                // si estabamos editando uno que ya estaba en el carrito, lo cambiamos
                if ($editIndex != "" && isset($_SESSION['carrito'][$editIndex])) {
                    $_SESSION['carrito'][$editIndex]['cantidad'] = $cantidadActual;
                    $_SESSION['carrito'][$editIndex]['ingredientes'] = $ingredientes;
                } else {
                    // si es nuevo, miramos si ya existe uno igual para sumar cantidad
                    $yaEstaba = false;
                    foreach ($_SESSION['carrito'] as $i => $item) {
                        if ($item['tipo'] == 'producto' && $item['id'] == $id && $item['ingredientes'] == $ingredientes) {
                            $_SESSION['carrito'][$i]['cantidad'] = $_SESSION['carrito'][$i]['cantidad'] + $cantidadActual;
                            $yaEstaba = true;
                        }
                    }

                    // si no estaba, lo metemos nuevo al final del carrito
                    if ($yaEstaba == false) {
                        $_SESSION['carrito'][] = [
                            'tipo' => 'producto',
                            'id' => $producto->getId(),
                            'nombre' => $producto->getNombre(),
                            'precio' => $producto->getPrecio(),
                            'imagen' => $producto->getImagen(),
                            'categoria_id' => $producto->getCategoriaId(),
                            'cantidad' => $cantidadActual,
                            'platos' => [],
                            'ingredientes' => $ingredientes
                        ];
                    }
                }

                // nos vamos al carrito
                header("Location: index.php?controller=Carrito&action=index");
                exit();
            }
        }

        // enseñamos la vista de detalle
        $view = "views/detalle.php";
        include_once("views/main.php");
    }
}