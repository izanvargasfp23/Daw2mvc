<?php
include_once("models/DAOs/ProductoDAO.php");

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
}