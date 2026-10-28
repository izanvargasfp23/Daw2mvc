<?php
require_once 'views/partials/header.php';
// Datos de ejemplo: el controlador debe pasar $productos
$productos = $productos ?? [
    ['id' => 1, 'nombre' => 'Hamburguesa clásica', 'precio' => 8.50],
    ['id' => 2, 'nombre' => 'Pizza barbacoa', 'precio' => 10.00],
    ['id' => 3, 'nombre' => 'Ensalada césar', 'precio' => 7.25],
];
?>
<section class="seccion">
    <h1>Carta</h1>
    <div class="grid">
        <?php foreach ($productos as $p): ?>
            <article class="tarjeta">
                <h3><?= htmlspecialchars($p['nombre']) ?></h3>
                <p class="precio"><?= number_format($p['precio'], 2, ',', '.') ?> €</p>
                <a href="<?= url ?>?controller=producto&action=detalle&id=<?= $p['id'] ?>" class="btn">Personalizar</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once 'views/partials/footer.php'; ?>
