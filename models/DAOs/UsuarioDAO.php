<?php
include_once("config/dataBase.php");

class UsuarioDAO
{
    // busca un usuario por su email para comprobar si existe al hacer login o registro
    public static function buscarPorEmail($email)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuario = $result->fetch_assoc();

        $stmt->close();
        $con->close();

        return $usuario;
    }

    // registra un usuario nuevo solo con lo basico
    public static function registrar($nombre, $email, $password)
    {
        $con = DataBase::connect();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $rol = "cliente";

        $stmt = $con->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $passwordHash, $rol);
        $ok = $stmt->execute();

        $stmt->close();
        $con->close();

        return $ok;
    }

    // guarda la calle, cp, ciudad y el telefono cuando el usuario hace un pedido
    public static function actualizarDatosEnvio($usuarioId, $telefono, $direccion, $cp, $ciudad)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE usuarios SET telefono = ?, direccion = ?, cp = ?, ciudad = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $telefono, $direccion, $cp, $ciudad, $usuarioId);
        $ok = $stmt->execute();

        $stmt->close();
        $con->close();

        return $ok;
    }

    // saca todas las ofertas activas que se pueden canjear con VP
    public static function obtenerOfertasDisponibles()
    {
        $con = DataBase::connect();
        $sql = "SELECT * FROM ofertas WHERE activa = 1 ORDER BY puntos_coste ASC";
        $result = $con->query($sql);

        $ofertas = [];
        while ($fila = $result->fetch_assoc()) {
            $ofertas[] = $fila;
        }

        $con->close();
        return $ofertas;
    }

    // saca las ofertas que este usuario ha canjeado y TODAVIA NO ha gastado
    public static function obtenerOfertasCanjeadas($usuarioId)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT uo.id AS canje_id, o.*, uo.fecha_canje FROM usuario_ofertas uo INNER JOIN ofertas o ON uo.oferta_id = o.id WHERE uo.usuario_id = ? AND uo.usada = 0 ORDER BY uo.fecha_canje DESC");
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();

        $canjeadas = [];
        while ($fila = $result->fetch_assoc()) {
            $canjeadas[] = $fila;
        }

        $stmt->close();
        $con->close();

        return $canjeadas;
    }

    // resta los puntos VP al usuario y le desbloquea la oferta
    public static function canjearOferta($usuarioId, $ofertaId)
    {
        $con = DataBase::connect();

        // 1. miramos cuantos puntos tiene el usuario
        $stmtUser = $con->prepare("SELECT puntos FROM usuarios WHERE id = ?");
        $stmtUser->bind_param("i", $usuarioId);
        $stmtUser->execute();
        $resUser = $stmtUser->get_result()->fetch_assoc();
        $stmtUser->close();

        // 2. miramos cuanto cuesta la oferta
        $stmtOf = $con->prepare("SELECT puntos_coste FROM ofertas WHERE id = ? AND activa = 1");
        $stmtOf->bind_param("i", $ofertaId);
        $stmtOf->execute();
        $resOf = $stmtOf->get_result()->fetch_assoc();
        $stmtOf->close();

        if (!$resUser || !$resOf) {
            $con->close();
            return false;
        }

        $puntosActuales = intval($resUser['puntos']);
        $coste = intval($resOf['puntos_coste']);

        // si no tiene puntos suficientes, salimos sin hacer nada
        if ($puntosActuales < $coste) {
            $con->close();
            return false;
        }

        // 3. restamos los puntos al usuario
        $stmtResta = $con->prepare("UPDATE usuarios SET puntos = puntos - ? WHERE id = ?");
        $stmtResta->bind_param("ii", $coste, $usuarioId);
        $stmtResta->execute();
        $stmtResta->close();

        // 4. guardamos el canje en la tabla intermedia
        $stmtGuarda = $con->prepare("INSERT INTO usuario_ofertas (usuario_id, oferta_id) VALUES (?, ?)");
        $stmtGuarda->bind_param("ii", $usuarioId, $ofertaId);
        $stmtGuarda->execute();
        $stmtGuarda->close();

        $con->close();
        return true;
    }

    // actualiza los datos del perfil desde el expediente del agente
    public static function actualizarPerfil($usuarioId, $nombre, $email, $telefono, $direccion, $cp, $ciudad, $password)
    {
        $con = DataBase::connect();

        if ($password != "") {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $con->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, direccion = ?, cp = ?, ciudad = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $nombre, $email, $telefono, $direccion, $cp, $ciudad, $passwordHash, $usuarioId);
        } else {
            $stmt = $con->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, direccion = ?, cp = ?, ciudad = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $nombre, $email, $telefono, $direccion, $cp, $ciudad, $usuarioId);
        }

        $ok = $stmt->execute();
        $stmt->close();
        $con->close();

        return $ok;
    }

    // suma los puntos VP ganados al usuario cuando hace un pedido
    public static function sumarPuntos($usuarioId, $puntos)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE usuarios SET puntos = puntos + ? WHERE id = ?");
        $stmt->bind_param("ii", $puntos, $usuarioId);
        $stmt->execute();

        $stmt->close();
        $con->close();
    }
}