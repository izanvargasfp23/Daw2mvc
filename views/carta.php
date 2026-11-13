<!-- Banner superior -->
<div class="w-100 overflow-hidden mb-4">
    <img src="img/webp/BannerCarta.webp" alt="La Carta" class="banner-carta-img">
</div>

<div class="container container-carta my-4">

    <!-- BOTÓN VOLVER AL INICIO -->
    <div class="mb-2">
        <a href="index.php?controller=Home&action=index" class="btn-volver">
            ← VOLVER AL INICIO
        </a>
    </div>

    <!-- ENTRANTES -->
    <h1 class="titulo-seccion-principal">ENTRANTES</h1>
    <div class="row g-4 mb-5">
        <?php foreach ($productos as$producto): ?>
            <?php if ($producto->getCategoriaId() == 1): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 card-producto">
                        <img src="img/webp/<?= $producto->getImagen() ?>" class="card-img-top" alt="<?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h5 class="card-title text-uppercase fw-bold"><?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="card-text small"><?= htmlspecialchars($producto->getDescripcion(), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex flex-column align-items-end mb-3 info-precio-vp">
                                    <span class="texto-precio"><?= number_format($producto->getPrecio(), 2, ',', '.') ?> €</span>
                                    <div class="d-inline-flex align-items-center gap-1 text-white-50" style="font-size: 0.85rem;">
                                        <span>+500</span>
                                        <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 16px; height: 16px;">
                                    </div>
                                </div>
                                <a href="index.php?controller=Producto&action=detalle&id=<?= $producto->getId() ?>" class="btn btn-valorant w-100">AÑADIR AL CARRITO</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- PRIMEROS -->
    <h2 class="titulo-seccion">PRIMEROS</h2>
    <div class="row g-4 mb-5">
        <?php foreach ($productos as$producto): ?>
            <?php if ($producto->getCategoriaId() == 2): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 card-producto">
                        <img src="img/webp/<?= $producto->getImagen() ?>" class="card-img-top" alt="<?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h5 class="card-title text-uppercase fw-bold"><?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="card-text small"><?= htmlspecialchars($producto->getDescripcion(), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex flex-column align-items-end mb-3 info-precio-vp">
                                    <span class="texto-precio"><?= number_format($producto->getPrecio(), 2, ',', '.') ?> €</span>
                                    <div class="d-inline-flex align-items-center gap-1 text-white-50" style="font-size: 0.85rem;">
                                        <span>+1000</span>
                                        <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 16px; height: 16px;">
                                    </div>
                                </div>
                               <a href="index.php?controller=Producto&action=detalle&id=<?= $producto->getId() ?>" class="btn btn-valorant w-100">AÑADIR AL CARRITO</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- SEGUNDOS -->
    <h2 class="titulo-seccion">SEGUNDOS</h2>
    <div class="row g-4 mb-5">
        <?php foreach ($productos as$producto): ?>
            <?php if ($producto->getCategoriaId() == 3): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 card-producto">
                        <img src="img/webp/<?= $producto->getImagen() ?>" class="card-img-top" alt="<?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h5 class="card-title text-uppercase fw-bold"><?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="card-text small"><?= htmlspecialchars($producto->getDescripcion(), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex flex-column align-items-end mb-3 info-precio-vp">
                                    <span class="texto-precio"><?= number_format($producto->getPrecio(), 2, ',', '.') ?> €</span>
                                    <div class="d-inline-flex align-items-center gap-1 text-white-50" style="font-size: 0.85rem;">
                                        <span>+2000</span>
                                        <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 16px; height: 16px;">
                                    </div>
                                </div>
                                <a href="index.php?controller=Producto&action=detalle&id=<?= $producto->getId() ?>" class="btn btn-valorant w-100">AÑADIR AL CARRITO</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- POSTRES -->
    <h2 class="titulo-seccion">POSTRES</h2>
    <div class="row g-4 mb-5">
        <?php foreach ($productos as$producto): ?>
            <?php if ($producto->getCategoriaId() == 4): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 card-producto">
                        <img src="img/webp/<?= $producto->getImagen() ?>" class="card-img-top" alt="<?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div>
                                <h5 class="card-title text-uppercase fw-bold"><?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="card-text small"><?= htmlspecialchars($producto->getDescripcion(), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex flex-column align-items-end mb-3 info-precio-vp">
                                    <span class="texto-precio"><?= number_format($producto->getPrecio(), 2, ',', '.') ?> €</span>
                                    <div class="d-inline-flex align-items-center gap-1 text-white-50" style="font-size: 0.85rem;">
                                        <span>+500</span>
                                        <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 16px; height: 16px;">
                                    </div>
                                </div>
                                <a href="index.php?controller=Producto&action=detalle&id=<?= $producto->getId() ?>" class="btn btn-valorant w-100"> AÑADIR AL CARRITO </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>