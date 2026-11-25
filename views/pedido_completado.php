<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <!-- caja oscura igual que la del perfil -->
            <div class="tarjeta-perfil p-4 p-md-5 text-center">

                <!-- titulo principal -->
                <h1 class="text-white text-uppercase display-5 mb-2">
                    ¡PEDIDO CONFIRMADO!
                </h1>

                <!-- linea roja fina debajo del titulo -->
                <hr class="border-danger opacity-75 mx-auto mb-4" style="width: 80px; border-width: 2px;">

                <!-- numero de pedido si existe -->
                <?php if (isset($_SESSION['ultimo_pedido_id'])) { ?>
                    <p class="text-white mb-2 fs-5">
                        Pedido <strong class="text-danger">#<?= $_SESSION['ultimo_pedido_id'] ?></strong>
                    </p>
                <?php } ?>

                <!-- puntos vp ganados -->
                <?php if (isset($_SESSION['ultimos_puntos_ganados']) && $_SESSION['ultimos_puntos_ganados'] > 0) { ?>
                    <p class="text-white-50 mb-4">
                        Has ganado <strong class="text-white">+<?= $_SESSION['ultimos_puntos_ganados'] ?> VP</strong> con esta compra.
                    </p>
                <?php } ?>

                <!-- mensaje normal -->
                <p class="text-white-50 mb-4">
                    Ya hemos recibido tu pedido y lo estamos preparando. Puedes ver todos los detalles desde tu perfil.
                </p>

                <!-- botones -->
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="index.php?controller=Usuario&action=perfil" class="boton-red m-0">
                        VER MIS PEDIDOS
                    </a>
                    <a href="index.php?controller=Producto&action=carta" class="boton-negro m-0">
                        VOLVER A LA CARTA
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>