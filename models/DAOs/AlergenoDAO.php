<?php
include_once("config/dataBase.php");

class AlergenoDAO
{
    public static function getByProductoId($producto_id)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT a.* FROM alergenos a 
                               JOIN producto_alergeno pa ON a.id = pa.alergeno_id 
                               WHERE pa.producto_id = ?");
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $alergenos = [];
        while ($row = $result->fetch_assoc()) {
            $alergenos[] = $row;
        }

        $stmt->close();
        $con->close();

        return $alergenos;
    }
}