<?php 
$total_carrito = 0;
if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total_carrito = $total_carrito + $item['cantidad'];
    }
}
?>

<header class="cabecera navbar navbar-expand-lg navbar-dark p-0">
    <div class="container contenedor-cabecera d-flex align-items-center justify-content-between">
        
        <!-- Logo (Lleva a la Home) -->
        <a href="index.php?controller=Home&action=index" class="logo text-decoration-none">
            <img src="img/Logo/LogoVE.svg" alt="Logo Valorant Eats">
        </a>

        <!-- Botón Hamburguesa (Solo se ve en móvil) -->
        <button class="navbar-toggler border-0 shadow-none p-0 ms-auto me-2" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Toggle navigation">
            <img src="img/svg/Hamburguer.svg" alt="Menú" width="25" height="25">
        </button>

        <!-- Bloque Navegación e Iconos -->
        <div class="collapse navbar-collapse menu-navegacion justify-content-between" id="menuNavegacion">
            
            <!-- Enlaces centrales -->
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

            <!-- Iconos de la derecha -->
            <div class="iconos-cabecera d-flex align-items-center justify-content-center gap-4 pb-3 pb-lg-0">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- icono avatar + nombre con menu desplegable -->
                    <div class="dropdown me-2">
                        <a href="#" class="dropdown-toggle text-decoration-none d-inline-flex align-items-center gap-2 text-white" data-bs-toggle="dropdown">
                            <img src="img/svg/avatar.svg" alt="Mi Cuenta" class="icono-header" width="22" height="22">
                            <span class="text-white text-uppercase fw-bold">
                                <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end mt-2">
                            <li>
                                <a class="dropdown-item text-uppercase small" href="index.php?controller=Usuario&action=perfil">
                                    Mi perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger text-uppercase small" href="index.php?controller=Usuario&action=logout">
                                    Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- si no has iniciado sesion, el icono lleva al login -->
                    <a href="index.php?controller=Usuario&action=login" class="text-decoration-none me-2" title="Iniciar sesión">
                        <img src="img/svg/avatar.svg" alt="Mi Cuenta" class="icono-header" width="22" height="22">
                    </a>
                <?php endif; ?>

                <a href="index.php?controller=Carrito&action=index" class="position-relative text-decoration-none">
                    <img src="img/svg/carrito-de-compras.svg" alt="Carrito" class="icono-header" width="22" height="22">
                    <?php if ($total_carrito > 0): ?>
                        <span class="contador-carrito position-absolute top-0 start-100 translate-middle badge rounded-pill">
                            <?= $total_carrito ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>

    </div>
</header>