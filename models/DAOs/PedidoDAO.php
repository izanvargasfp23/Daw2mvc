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

                    $accion = "incluido";
                    if ($cantIng == 0) {
                        $accion = "quitado";
                    }
                    if ($cantIng > 1) {
                        $accion = "añadido";
                    }

                    $precioExtra = 0.00;
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