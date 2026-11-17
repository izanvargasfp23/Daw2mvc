<?php
// Si la variable viene del controlador se usa directamente; si no, array vacío
$lista_menus = $lista_menus ?? [];
?>

<!-- 1. BANNER HERO MENÚS -->
<section class="w-100 p-0 m-0">
    <img src="img/webp/BannerMenu.webp" alt="Valorant Eats Menús Banner" class="banner-carta-img">
</section>

<!-- 2. CONTENIDO PRINCIPAL -->
<main class="py-5">
    <div class="container container-carta">
        
        <!-- Enlace volver y Título de Sección -->
        <div class="mb-4">
            <a href="index.php?controller=Home&action=index" class="btn-volver d-inline-block mb-2">
                ← VOLVER AL INICIO
            </a>
            <h2 class="titulo-seccion-principal text-uppercase m-0">MENÚS</h2>
        </div>

        <!-- Grid Dinámico desde la Tabla `menus` y `menu_producto` -->
        <div class="row g-4 justify-content-center">
            <?php if (!empty($lista_menus)): ?>
                <?php foreach ($lista_menus as $menu): ?>
                    <?php 
                        $labels = ['PRIMERO', 'SEGUNDO', 'POSTRE', 'BEBIDA'];
                        $vpMenu = intval(round($menu['precio'] * 100));
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 card-producto p-3">
                            
                            <!-- Imagen dinámica desde la tabla `menus` -->
                            <img src="img/webp/<?= htmlspecialchars($menu['imagen']) ?>" class="card-img-top rounded-1 mb-3" alt="<?= htmlspecialchars($menu['nombre']) ?>">
                            
                            <div class="card-body p-0 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="fw-bold text-uppercase d-block mb-1 text-danger">VALORANT EATS</small>
                                    
                                    <!-- Nombre dinámico del Menú -->
                                    <h3 class="card-title text-uppercase fw-bold mb-3">
                                        <?= htmlspecialchars($menu['nombre']) ?>
                                    </h3>

                                    <!-- Desglose de Platos Relacionados mediante JOIN -->
                                    <div class="border-top border-bottom border-secondary border-opacity-25 my-3">
                                        <?php foreach ($labels as $idx => $label): ?>
                                            <div class="d-flex justify-content-between align-items-center py-2 <?= $idx < count($labels) - 1 ? 'border-bottom border-secondary border-opacity-25' : '' ?>">
                                                <span class="text-danger fw-bold small text-uppercase"><?= $label ?></span>
                                                <span class="text-white small text-uppercase fw-semibold text-end ms-3">
                                                    <?= htmlspecialchars($menu['platos'][$label]) ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Precios, VP y Acción de Carrito (igual que en carta.php) -->
                                <div class="mt-3">
                                    <div class="d-flex flex-column align-items-end mb-3 info-precio-vp">
                                        <span class="texto-precio"><?= number_format($menu['precio'], 2, ',', '.') ?> €</span>
                                        <div class="d-inline-flex align-items-center gap-1 text-white-50 texto-vp">
                                            <span>+<?= $vpMenu ?></span>
                                            <img src="img/svg/Valorant_Point.svg" alt="VP" class="icono-vp-card">
                                        </div>
                                    </div>
                                    <a href="index.php?controller=Carrito&action=add&id=<?= $menu['id'] ?>&type=menu" class="btn btn-valorant w-100 text-uppercase">
                                        AÑADIR AL CARRITO
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-white-50 py-5">
                    <p>No se encontraron menús en la base de datos.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>