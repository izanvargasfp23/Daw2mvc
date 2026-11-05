<?php 
$total_carrito = 0;
if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['carrito'])) {
    $total_carrito = count($_SESSION['carrito']);
}
?>

<header class="cabecera navbar navbar-expand-lg navbar-dark p-0">
    <div class="container contenedor-cabecera d-flex align-items-center justify-content-between">
        
        <!-- Logo -->
        <a href="index.php?controller=Home&action=index" class="logo text-decoration-none">
            <img src="img/Logo/Logo.png" alt="Logo Valorant Eats">
        </a>

        <!-- Botón Hamburguesa (Solo se ve en móvil) -->
        <button class="navbar-toggler border-0 shadow-none p-0 ms-auto me-2" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Toggle navigation">
            <img src="img/svg/Hamburguer.svg" alt="Menú" style="width: 25px; height: 25px;">
        </button>

        <!-- Bloque Navegación e Iconos -->
        <div class="collapse navbar-collapse menu-navegacion justify-content-between" id="menuNavegacion">
            
            <!-- Enlaces centrales (se centran solos en PC gracias a mx-auto) -->
            <ul class="navbar-nav mx-auto text-center py-2 py-lg-0">
                <li class="nav-item mx-lg-3">
                    <a href="index.php?controller=Producto&action=carta" class="nav-link text-white text-uppercase">CARTA</a>
                </li>
                <li class="nav-item mx-lg-3">
                    <a href="index.php?controller=Producto&action=chefs" class="nav-link text-white text-uppercase">CHEFS</a>
                </li>
                <li class="nav-item mx-lg-3">
                    <a href="index.php?controller=Producto&action=menus" class="nav-link text-white text-uppercase">MENÚS</a>
                </li>
            </ul>

            <!-- Iconos de la derecha (Lupa y Carrito) -->
            <div class="iconos-cabecera d-flex align-items-center justify-content-center gap-3 pb-3 pb-lg-0">
                <button class="boton-buscar border-0 p-0" id="btn-buscar" type="button">
                    <img src="img/svg/lupa.svg" alt="Buscar">
                </button>

                <a href="index.php?controller=Carrito&action=index" class="icono-carrito position-relative d-flex align-items-center text-decoration-none">
                    <img src="img/svg/carrito-de-compras.svg" alt="Carrito">
                    <?php if ($total_carrito > 0): ?>
                        <span class="contador-carrito position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $total_carrito ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>

        </div>

    </div>
</header>