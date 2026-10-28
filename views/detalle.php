<?php
require_once 'views/partials/header.php';
// Datos de ejemplo: el controlador debe pasar $producto e $ingredientes
$producto = $producto ?? ['id' => 1, 'nombre' => 'Hamburguesa clásica', 'precio' => 8.50];
$ingredientes = $ingredientes ?? [
    ['id' => 1, 'nombre' => 'Queso extra', 'precio' => 0.80],
    ['id' => 2, 'nombre' => 'Bacon', 'precio' => 1.20],
    ['id' => 3, 'nombre' => 'Cebolla', 'precio' => 0.00],
];
?>
<section class="seccion">
    <h1><?= htmlspecialchars($producto['nombre']) ?></h1>
    <p class="precio">Desde <?= number_format($producto['precio'], 2, ',', '.') ?> €</p>
    <form method="post" action="<?= url ?>?controller=carrito&action=anadir">
        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
        <fieldset>
            <legend>Ingredientes extra</legend>
            <?php foreach ($ingredientes as $i): ?>
                <label class="check">
                    <input type="checkbox" name="ingredientes[]" value="<?= $i['id'] ?>">
                    <?= htmlspecialchars($i['nombre']) ?> (+<?= number_format($i['precio'], 2, ',', '.') ?> €)
                </label>
            <?php endforeach; ?>
        </fieldset>
        <button class="btn" type="submit">Añadir al carrito</button>
    </form>
</section>
<?php require_once 'views/partials/footer.php'; ?>
