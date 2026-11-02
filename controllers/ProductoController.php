<?php
include_once("models/DAOs/ProductoDAO.php");

class ProductoController
{
    public function carta()
    {
        $entrantes = ProductoDAO::getByCategoria(ProductoBase::TYPE_ENTRANTES);
        $primeros  = ProductoDAO::getByCategoria(ProductoBase::TYPE_PRIMEROS);
        $segundos  = ProductoDAO::getByCategoria(ProductoBase::TYPE_SEGUNDOS);
        $postres   = ProductoDAO::getByCategoria(ProductoBase::TYPE_POSTRES);

        $view = "views/carta.php";
        include_once("views/main.php");
    }
}