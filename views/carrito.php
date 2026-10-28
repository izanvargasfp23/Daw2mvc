<?php
require_once 'views/partials/header.php';
// Datos de ejemplo: el controlador debe pasar $lineas (nombre, cantidad, precio)
$lineas = $lineas ?? [['nombre' => 'Hamburguesa clásica + Bacon', 'cantidad' => 2, 'precio' => 9.70]];
$subtotal = array_sum(array_map(fn($l) => $l['cantidad'] * $l['precio'], $lineas));
$iva = $subtotal * 0.10;
?>
<section class="seccion">
    <h1>Tu carrito</h1>
    <table class="tabla">
        <tr><th>Producto</th><th>Cant.</th><th>Precio</th><th></th></tr>
        <?php foreach ($lineas as $k => $l): ?>
            <tr>
                <td><?= htmlspecialchars($l['nombre']) ?></td>
                <td><?= $l['cantidad'] ?></td>
                <td><?= number_format($l['precio'] * $l['cantidad'], 2, ',', '.') ?> €</td>
                <td><a href="<?= url ?>?controller=carrito&action=eliminar&linea=<?= $k ?>">Quitar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>Subtotal: <?= number_format($subtotal, 2, ',', '.') ?> €</p>
    <p>IVA (10%): <?= number_format($iva, 2, ',', '.') ?> €</p>
    <p class="precio">Total: <?= number_format($subtotal + $iva, 2, ',', '.') ?> €</p>
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="<?= url ?>?controller=pedido&action=finalizar" class="btn">Finalizar compra</a>
    <?php else: ?>
        <p>Inicia sesión para finalizar la compra.</p>
        <a href="<?= url ?>?controller=auth&action=login" class="btn">Entrar</a>
    <?php endif; ?>
</section>
<?php require_once 'views/partials/footer.php'; ?>
