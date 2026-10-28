<?php require_once 'views/partials/header.php'; ?>
<section class="banner">
    <h1>Valorant Eats</h1>
    <p>Pide tu menú favorito y personalízalo a tu gusto.</p>
    <a href="<?= url ?>?controller=producto&action=index" class="btn">Ver carta</a>
</section>
<section class="seccion">
    <h2>Ofertas</h2>
    <p>Menús completos a precio especial. Añádelos al carrito en un clic.</p>
    <a href="<?= url ?>?controller=oferta&action=index" class="btn">Ver ofertas</a>
</section>
<section class="seccion seccion--alt">
    <h2>Nuestra carta</h2>
    <p>Elige un producto y añade o quita ingredientes.</p>
    <a href="<?= url ?>?controller=producto&action=index" class="btn">Ir a la carta</a>
</section>
<section class="seccion">
    <h2>Nuestros chefs</h2>
    <p>Conoce al equipo que cocina cada pedido.</p>
</section>
<?php require_once 'views/partials/footer.php'; ?>
