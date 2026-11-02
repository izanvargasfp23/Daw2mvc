<?php
include_once("models/ProductoBase.php");

class Producto extends ProductoBase
{
    public function __construct($nombre = null, $descripcion = null, $precio = null, $imagen = null, $categoria_id = null)
    {
        parent::__construct($nombre, $descripcion, $precio, $imagen, $categoria_id);
    }
}