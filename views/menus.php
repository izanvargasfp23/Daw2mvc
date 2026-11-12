<?php
// Si la variable viene del controlador se usa directamente; si no, array vacío
$lista_menus = $lista_menus ?? [];
?>

<!-- 1. BANNER HERO MENÚS -->
<section class="w-100 p-0 m-0">
    <img src="img/webp/BannerMenu.webp" alt="Valorant Eats Menús Banner" class="img-fluid w-100 d-block" style="max-height: 400px; object-fit: cover;">
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
                    ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card card-producto h-100 border-0 p-3" style="background-color: #1b2733; border-radius: 4px;">
                            
                            <!-- Imagen dinámica desde la tabla `menus` -->
                            <img src="img/webp/<?= htmlspecialchars($menu['imagen']) ?>" class="card-img-top rounded-1 mb-3" alt="<?= htmlspecialchars($menu['nombre']) ?>" style="height: 230px; object-fit: cover;">
                            
                            <div class="card-body p-0 d-flex flex-column justify-content-between">
                                <div>
                                    <small class="fw-bold text-uppercase d-block mb-1 text-danger" style="font-size: 0.75rem; letter-spacing: 0.5px;">VALORANT EATS</small>
                                    
                                    <!-- Nombre dinámico del Menú -->
                                    <h3 class="h4 text-white text-uppercase fw-bold mb-3" style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 1px;">
                                        <?= htmlspecialchars($menu['nombre']) ?>
                                    </h3>

                                    <!-- Desglose de Platos Relacionados mediante JOIN -->
                                    <div class="border-top border-bottom border-secondary border-opacity-25 my-3">
                                        <?php foreach ($labels as $idx => $label): ?>
                                            <div class="d-flex justify-content-between align-items-center py-2 <?= $idx < count($labels) - 1 ? 'border-bottom border-secondary border-opacity-25' : '' ?>">
                                                <span class="text-danger fw-bold small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;"><?= $label ?></span>
                                                <span class="text-white small text-uppercase fw-semibold text-end ms-3" style="font-size: 0.8rem;">
                                                    <?= htmlspecialchars($menu['platos'][$label]) ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Precios y Acción de Carrito -->
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3 text-white fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem;">
                                        <span><?= number_format($menu['precio'] * 100, 0) ?> VPOINTS</span>
                                        <span>[ <?= number_format($menu['precio'], 2, ',', '.') ?>€ ]</span>
                                    </div>
                                    <a href="index.php?controller=Carrito&action=add&id=<?= $menu['id'] ?>&type=menu" class="boton-red w-100 text-center text-uppercase d-block">
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