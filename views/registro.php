<?php require_once 'views/partials/header.php'; ?>
<section class="seccion seccion--estrecha">
    <h1>Crear cuenta</h1>
    <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="post" action="<?= url ?>?controller=auth&action=registro">
        <label>Nombre <input type="text" name="nombre" required></label>
        <label>Email <input type="email" name="email" required></label>
        <label>Contraseña <input type="password" name="password" minlength="6" required></label>
        <button class="btn" type="submit">Registrarme</button>
    </form>
</section>
<?php require_once 'views/partials/footer.php'; ?>
