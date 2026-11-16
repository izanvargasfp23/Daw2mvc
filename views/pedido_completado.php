<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <!-- tarjeta oscura estilo valorant -->
            <div class="tarjeta-perfil p-4 p-md-5 text-center">

                <!-- icono verde de confirmacion -->
                <div class="mb-3">
                    <span class="badge bg-success rounded-circle p-3 fs-3">✓</span>
                </div>

                <span class="d-block text-danger fw-bold titulo fs-5 mb-1">
                    // OPERACIÓN COMPLETADA
                </span>

                <h1 class="text-white text-uppercase display-5 mb-3">
                    ¡PEDIDO CONFIRMADO!
                </h1>

                <!-- numero de pedido guardado en la sesion -->
                <?php if (isset($_SESSION['ultimo_pedido_id'])): ?>
                    <p class="text-white-50 mb-3">
                        Número de pedido: <strong class="text-white">#<?= $_SESSION['ultimo_pedido_id'] ?></strong>
                    </p>
                <?php endif; ?>

                <p class="text-white-50 mb-4">
                    Tu comanda ya ha entrado en cocina. Puedes revisar el estado y todos tus pedidos desde tu perfil de agente.
                </p>

                <!-- botones para ir al perfil o volver a la carta -->
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