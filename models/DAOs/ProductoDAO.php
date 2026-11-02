<?php
include_once("config/dataBase.php");
include_once("models/ProductoBase.php");
include_once("models/Producto.php");

class ProductoDAO
{
    public static function getAll()
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos");
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($producto = $result->fetch_object("Producto")) {
            $productos[] = $producto;
        }

        $stmt->close();
        $con->close();

        return $productos;
    }

    public static function getByCategoria($categoria_id)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE categoria_id = ?");
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($producto = $result->fetch_object("Producto")) {
            $productos[] = $producto;
        }

        $stmt->close();
        $con->close();

        return $productos;
    }

    public static function getById($id)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $producto = $result->fetch_object("Producto");

        $stmt->close();
        $con->close();

        return $producto ?: null;
    }
}