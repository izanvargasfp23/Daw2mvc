<?php
require_once 'views/partials/header.php';
// Datos de ejemplo: el controlador debe pasar $usuario y $ultimoPedido
$usuario = $usuario ?? ['nombre' => 'Nombre', 'email' => 'correo@ejemplo.com'];
$ultimoPedido = $ultimoPedido ?? null;
?>
<section class="seccion seccion--estrecha">
    <h1>Mi cuenta</h1>
    <form method="post" action="<?= url ?>?controller=usuario&action=actualizar">
        <label>Nombre <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required></label>
        <label>Email <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required></label>
        <button class="btn" type="submit">Guardar cambios</button>
    </form>
    <h2>Último pedido</h2>
    <?php if ($ultimoPedido): ?>
        <p>Pedido #<?= $ultimoPedido['id'] ?> · <?= number_format($ultimoPedido['total'], 2, ',', '.') ?> €</p>
    <?php else: ?>
        <p>Todavía no has hecho ningún pedido.</p>
    <?php endif; ?>
    <a href="<?= url ?>?controller=auth&action=logout">Cerrar sesión</a>
</section>
<?php require_once 'views/partials/footer.php'; ?>
