<?php
class MenuDAO {
    public static function getAllWithPlatos() {
        $con = DataBase::connect();
        $sql = "SELECT 
                    m.id AS menu_id,
                    m.nombre AS menu_nombre,
                    m.descripcion AS menu_descripcion,
                    m.precio AS menu_precio,
                    m.imagen AS menu_imagen,
                    mp.tipo_plato,
                    p.nombre AS plato_nombre
                FROM menus m
                LEFT JOIN menu_producto mp ON m.id = mp.menu_id
                LEFT JOIN productos p ON mp.producto_id = p.id
                WHERE m.activo = 1
                ORDER BY m.id ASC";
        
        $menus = [];

        // Compatible con PDO y mysqli
        if ($con instanceof PDO) {
            $stmt = $con->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = $con->query($sql);
            $rows = [];
            while ($r = $result->fetch_assoc()) {
                $rows[] = $r;
            }
        }

        foreach ($rows as $row) {
            $id = $row['menu_id'];
            if (!isset($menus[$id])) {
                $menus[$id] = [
                    'id'          => $row['menu_id'],
                    'nombre'      => $row['menu_nombre'],
                    'descripcion' => $row['menu_descripcion'],
                    'precio'      => $row['menu_precio'],
                    'imagen'      => $row['menu_imagen'],
                    'platos'      => [
                        'PRIMERO' => '-',
                        'SEGUNDO' => '-',
                        'POSTRE'  => '-',
                        'BEBIDA'  => '-'
                    ]
                ];
            }
            if (!empty($row['tipo_plato']) && !empty($row['plato_nombre'])) {
                $menus[$id]['platos'][$row['tipo_plato']] = $row['plato_nombre'];
            }
        }

        return $menus;
    }
}
?>