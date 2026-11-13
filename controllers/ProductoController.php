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

        // si vienes desde EDITAR en la cesta, cargamos tus ingredientes y cantidad
        if (isset($_GET['edit']) && isset($_SESSION['carrito'][$_GET['edit']])) {
            $editIndex = $_GET['edit'];
            $itemCesta = $_SESSION['carrito'][$editIndex];
            $cantidadActual = $itemCesta['cantidad'];

            if (!empty($itemCesta['ingredientes'])) {
                $ingredientes = $itemCesta['ingredientes'];
            }
        }

        $view = "views/detalle.php";
        include_once("views/main.php");
    }
}