<?php
include_once("config/dataBase.php");

class PedidoDAO
{
    // busca si el codigo de descuento existe y esta activo
    public static function buscarCupon($codigo)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas WHERE codigo = ? AND activa = 1");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        $oferta = $result->fetch_assoc();

        $stmt->close();
        $con->close();

        return $oferta;
    }

    // comprueba si este usuario tiene el cupon canjeado y todavia sin gastar
    public static function buscarCuponUsuario($usuarioId, $codigo)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT uo.id AS canje_id, o.* FROM usuario_ofertas uo INNER JOIN ofertas o ON uo.oferta_id = o.id WHERE uo.usuario_id = ? AND o.codigo = ? AND o.activa = 1 AND uo.usada = 0 LIMIT 1");
        $stmt->bind_param("is", $usuarioId, $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        $oferta = $result->fetch_assoc();

        $stmt->close();
        $con->close();

        return $oferta;
    }

    // marca el cupon canjeado como gastado para que desaparezca del perfil
    public static function marcarCuponUsado($canjeId)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE usuario_ofertas SET usada = 1 WHERE id = ?");
        $stmt->bind_param("i", $canjeId);
        $stmt->execute();

        $stmt->close();
        $con->close();
    }

    // guarda el pedido completo en las 3 tablas
    public static function guardarPedido($usuarioId, $subtotal, $descuento, $total, $metodoPago, $carrito)
    {
        $con = DataBase::connect();

        // 1. guardamos la cabecera del pedido
        $estado = "confirmado";
        $estadoPago = "pagado";

        $stmt = $con->prepare("INSERT INTO pedidos (usuario_id, estado, subtotal, descuento, total, metodo_pago, estado_pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdddss", $usuarioId, $estado, $subtotal, $descuento, $total, $metodoPago, $estadoPago);
        $stmt->execute();

        // cogemos el id del pedido que se acaba de crear
        $pedidoId = $con->insert_id;
        $stmt->close();

        // 2. recorremos el carrito para guardar cada plato o menu
        foreach ($carrito as $item) {
            $nombreProd = $item['nombre'];
            $precioUnit = $item['precio'];
            $cantidad = $item['cantidad'];
            $subtotalLinea = $precioUnit * $cantidad;

            // si es un menu, producto_id va vacio (NULL)
            if (isset($item['tipo']) && $item['tipo'] == 'menu') {
                $stmtDet = $con->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES (?, NULL, ?, ?, ?, ?)");
                $stmtDet->bind_param("isdid", $pedidoId, $nombreProd, $precioUnit, $cantidad, $subtotalLinea);
            } else {
                // si es un plato suelto, guardamos su producto_id
                $prodId = $item['id'];
                $stmtDet = $con->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtDet->bind_param("iisdid", $pedidoId, $prodId, $nombreProd, $precioUnit, $cantidad, $subtotalLinea);
            }

            $stmtDet->execute();
            $detalleId = $con->insert_id;
            $stmtDet->close();

            // 3. si ese plato llevaba ingredientes personalizados, los guardamos
            if (!empty($item['ingredientes'])) {
                foreach ($item['ingredientes'] as $ing) {
                    $nombreIng = $ing['nombre'];
                    $cantIng = intval($ing['cantidad']);

                    $cantBase = 1;
                    if (isset($ing['cantidad_base'])) {
                        $cantBase = intval($ing['cantidad_base']);
                    }

                    $precioExtraUnit = 0.00;
                    if (isset($ing['precio_extra'])) {
                        $precioExtraUnit = floatval($ing['precio_extra']);
                    }

                    $accion = "incluido";
                    $precioExtra = 0.00;

                    if ($cantIng == 0) {
                        $accion = "quitado";
                    } else if ($cantIng > $cantBase) {
                        $accion = "añadido";
                        $precioExtra = ($cantIng - $cantBase) * $precioExtraUnit;
                    }

                    $stmtIng = $con->prepare("INSERT INTO pedido_detalle_ingrediente (pedido_detalle_id, ingrediente_id, nombre_ingrediente, precio_extra, accion) VALUES (?, NULL, ?, ?, ?)");
                    $stmtIng->bind_param("isds", $detalleId, $nombreIng, $precioExtra, $accion);
                    $stmtIng->execute();
                    $stmtIng->close();
                }
            }
        }

        $con->close();

        return $pedidoId;
    }

    // saca todos los pedidos de un usuario para enseñarlos en su perfil
    public static function obtenerPedidosPorUsuario($usuarioId)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC");
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();

        $pedidos = [];
        while ($fila = $result->fetch_assoc()) {
            $pedidos[] = $fila;
        }

        $stmt->close();
        $con->close();

        return $pedidos;
    }
}