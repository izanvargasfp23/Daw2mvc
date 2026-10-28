<?php $total = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Valorant Eats</title>
    <link rel="stylesheet" href="<?= url ?>css/estilos.css">
</head>
<body>
<header class="header">
    <a href="<?= url ?>" class="header__logo"><img src="<?= url ?>img/LogoValorantFondoNegro.png" alt="Valorant Eats"></a>
    <nav class="header__menu">
        <a href="<?= url ?>?controller=producto&action=index">Carta</a>
        <a href="<?= url ?>?controller=chef&action=index">Chefs</a>
        <a href="<?= url ?>?controller=oferta&action=index">Menús</a>
    </nav>
    <div class="header__iconos">
        <a href="<?= url ?>?controller=producto&action=buscar" class="header__buscar"><img src="<?= url ?>img/iconos/lupa.svg" alt="Buscar"></a>
        <a href="<?= url ?>?controller=carrito&action=index" class="header__carrito"><img src="<?= url ?>img/iconos/carrito-de-compras.svg" alt="Carrito"><?php if ($total): ?><span><?= $total ?></span><?php endif; ?></a>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="<?= url ?>?controller=usuario&action=perfil">Mi cuenta</a>
        <?php else: ?>
            <a href="<?= url ?>?controller=auth&action=login">Entrar</a>
        <?php endif; ?>
    </div>
</header>
<main>
