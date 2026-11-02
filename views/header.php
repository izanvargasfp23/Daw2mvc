<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$total_carrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; 
?>

<header class="cabecera" style="background-color: #111A23; width: 100%; height: 154px;">
    <div class="container h-100 d-flex align-items-center justify-content-between">
        
        <!-- Logo ampliado -->
        <div class="logo d-flex align-items-center">
            <a href="index.php?controller=Home&action=index" class="d-flex align-items-center">
                <img src="img/Logo/Logo.png" alt="Logo Valorant Eats" style="height: 95px; object-fit: contain;">
            </a>
        </div>

        <!-- Menú principal centrado vertical y horizontalmente -->
        <nav class="menu-navegacion d-flex align-items-center h-100">
            <ul class="d-flex align-items-center gap-5 m-0 p-0" style="list-style: none;">
                <li>
                    <a href="index.php?controller=Producto&action=carta" 
                       class="text-white text-decoration-none text-uppercase" 
                       style="font-family: 'Bebas Neue', sans-serif; font-size: 1.75rem; letter-spacing: 1px; line-height: 1; display: inline-block;">
                        CARTA
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=Producto&action=chefs" 
                       class="text-white text-decoration-none text-uppercase" 
                       style="font-family: 'Bebas Neue', sans-serif; font-size: 1.75rem; letter-spacing: 1px; line-height: 1; display: inline-block;">
                        CHEFS
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=Producto&action=menus" 
                       class="text-white text-decoration-none text-uppercase" 
                       style="font-family: 'Bebas Neue', sans-serif; font-size: 1.75rem; letter-spacing: 1px; line-height: 1; display: inline-block;">
                        MENÚS
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Iconos de la derecha -->
        <div class="iconos-cabecera d-flex align-items-center gap-3">
            <!-- Botón buscador -->
            <button class="boton-buscar border-0 p-2 d-flex align-items-center justify-content-center" 
                    id="btn-buscar" 
                    style="background-color: rgba(255,255,255,0.15); border-radius: 4px; cursor: pointer; width: 44px; height: 44px;">
                <img src="img/svg/lupa.svg" alt="Buscar" style="width: 20px; height: 20px;">
            </button>

            <!-- Icono carrito con badge dinámico -->
            <a href="index.php?controller=Carrito&action=index" class="icono-carrito position-relative d-flex align-items-center text-decoration-none p-1">
                <img src="img/svg/carrito-de-compras.svg" alt="Carrito" style="width: 28px; height: 28px;">
                <?php if ($total_carrito > 0): ?>
                    <span class="contador-carrito position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                        <?= $total_carrito ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>

    </div>
</header>