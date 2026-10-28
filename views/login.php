<?php require_once 'views/partials/header.php'; ?>
<section class="seccion seccion--estrecha">
    <h1>Iniciar sesión</h1>
    <?php if (!empty($error)): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="post" action="<?= url ?>?controller=auth&action=login">
        <label>Email <input type="email" name="email" required></label>
        <label>Contraseña <input type="password" name="password" required></label>
        <button class="btn" type="submit">Entrar</button>
    </form>
    <p>¿No tienes cuenta? <a href="<?= url ?>?controller=auth&action=registro">Regístrate</a></p>
</section>
<?php require_once 'views/partials/footer.php'; ?>
