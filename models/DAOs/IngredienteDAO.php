<?php
include_once("config/dataBase.php");

class IngredienteDAO
{
    public static function getByProductoId($producto_id)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT i.*, pi.cantidad FROM ingredientes i 
                               JOIN producto_ingrediente pi ON i.id = pi.ingrediente_id 
                               WHERE pi.producto_id = ? AND i.activo = 1");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ingredientes = [];
        while ($row = $result->fetch_assoc()) {
            $ingredientes[] = $row;
        }

        $stmt->close();
        $con->close();

        return $ingredientes;
    }
}