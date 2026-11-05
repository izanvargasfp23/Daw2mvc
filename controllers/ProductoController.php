<?php
include_once("models/DAOs/ProductoDAO.php");

class ProductoController
{
    public function carta()
    {
        // 1. Obtener los productos desde el DAO
        $productos = ProductoDAO::getAll();

        // 2. Definir la vista interna y llamar a la plantilla principal
        $view = "views/carta.php";
        include_once("views/main.php");
    }
}