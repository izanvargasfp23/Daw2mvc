<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$total_carrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valorant Eats</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="cabecera">
    <div class="contenedor-cabecera">
        
        <!-- Logo -->
        <div class="logo">
            <a href="index.php">
                <img src="img/Logo/Logo.png" alt="Logo Valorant Eats">
            </a>
        </div>

        <!-- Menú principal -->
        <nav class="menu-navegacion">
            <ul>
                <li><a href="index.php?controller=Producto&action=carta">CARTA</a></li>
                <li><a href="index.php?controller=Producto&action=chefs">CHEFS</a></li>
                <li><a href="index.php?controller=Producto&action=menus">MENÚS</a></li>
            </ul>
        </nav>

        <!-- Iconos de la derecha -->
        <div class="iconos-cabecera">
            <!-- Botón buscador -->
            <button class="boton-buscar" id="btn-buscar">
                <img src="img/svg/lupa.svg" alt="Buscar">
            </button>

            <!-- Icono carrito -->
            <a href="index.php?controller=Carrito&action=index" class="icono-carrito">
                <img src="img/svg/carrito-de-compras.svg" alt="Carrito">
                <?php if ($total_carrito > 0): ?>
                    <span class="contador-carrito"><?= $total_carrito ?></span>
                <?php endif; ?>
            </a>
        </div>

    </div>
</header>
<main class="contenido-principal">
</body>
