<div class="container-fluid p-0">
    <form action="index.php?controller=Pedido&action=confirmar" method="POST">
        <div class="row g-0 min-vh-100">

            <!-- LADO IZQUIERDO: FORMULARIO DE DATOS -->
            <div class="col-12 col-lg-7 bg-white text-dark py-5 px-4 px-md-5 d-flex justify-content-lg-end">
                <div class="w-100" style="max-width: 540px;">

                    <!-- logo arriba -->
                    <div class="mb-4">
                        <a href="index.php?controller=Home&action=index" class="text-decoration-none">
                            <img src="img/Logo/LogoVE.svg" alt="Logo Valorant Eats" style="height: 55px;">
                        </a>
                    </div>

                    <!-- mensaje rojo si falta algun dato obligatorio -->
                    <?php if ($errorFormulario != "") { ?>
                        <div class="alert alert-danger py-2 px-3 small mb-4">
                            <?= $errorFormulario ?>
                        </div>
                    <?php } ?>

                    <!-- apartado 1: contacto -->
                    <h4 class="fw-bold mb-3" style="font-size: 1.25rem; color: #111A23;">
                        Información de contacto
                    </h4>

                    <div class="mb-2">
                        <input type="email" name="email" class="form-control py-2 px-3" placeholder="Correo electrónico" value="<?= $email ?>">
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="checkNovedades" name="novedades">
                        <label class="form-check-label small text-dark" for="checkNovedades">
                            Mantenerme al día de las novedades y ofertas exclusivas
                        </label>
                    </div>

                    <!-- apartado 2: direccion de entrega -->
                    <h4 class="fw-bold mb-3" style="font-size: 1.25rem; color: #111A23;">
                        Entrega
                    </h4>

                    <!-- aviso naranja -->
                    <div class="d-flex align-items-start gap-2 p-3 mb-3 small" style="background-color: #FFF0E5; border: 1px solid #F5C29B; border-radius: 6px; color: #333;">
                        <span class="fw-bold">⚠️</span>
                        <span>Asegúrate de que la dirección es correcta para evitar problemas al procesar o entregar el pedido.</span>
                    </div>

                    <!-- pais -->
                    <div class="form-floating mb-3">
                        <select class="form-select" id="selectPais" name="pais">
                            <option value="España" <?php if ($pais == 'España') { echo 'selected'; } ?>>España</option>
                            <option value="Portugal" <?php if ($pais == 'Portugal') { echo 'selected'; } ?>>Portugal</option>
                            <option value="Francia" <?php if ($pais == 'Francia') { echo 'selected'; } ?>>Francia</option>
                            <option value="Andorra" <?php if ($pais == 'Andorra') { echo 'selected'; } ?>>Andorra</option>
                        </select>
                        <label for="selectPais">País / región</label>
                    </div>

                    <!-- nombre y apellido -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-6">
                            <input type="text" name="nombre" class="form-control py-2 px-3" placeholder="Nombre" value="<?= $nombre ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" name="apellido" class="form-control py-2 px-3" placeholder="Apellido" value="<?= $apellido ?>">
                        </div>
                    </div>

                    <!-- calle -->
                    <div class="mb-3">
                        <input type="text" name="direccion" class="form-control py-2 px-3" placeholder="Dirección" value="<?= $direccion ?>">
                    </div>

                    <!-- piso o puerta -->
                    <div class="mb-3">
                        <input type="text" name="edificio" class="form-control py-2 px-3" placeholder="Edificio, número, etc. (opcional)" value="<?= $edificio ?>">
                    </div>

                    <!-- codigo postal y ciudad -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-6">
                            <input type="text" name="cp" class="form-control py-2 px-3" placeholder="Código postal" value="<?= $cp ?>">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" name="ciudad" class="form-control py-2 px-3" placeholder="Ciudad" value="<?= $ciudad ?>">
                        </div>
                    </div>

                    <!-- telefono -->
                    <div class="mb-4">
                        <input type="text" name="telefono" class="form-control py-2 px-3" placeholder="Teléfono (opcional)" value="<?= $telefono ?>">
                    </div>

                    <!-- apartado 3: metodo de pago (sin JS, controlado por CSS) -->
                    <h4 class="fw-bold mb-3" style="font-size: 1.25rem; color: #111A23;">
                        Pago
                    </h4>

                    <div class="caja-metodos-pago mb-4">
                        <!-- opcion 1: tarjeta -->
                        <input class="radio-pago" type="radio" name="metodo_pago" id="pagoTarjeta" value="Tarjeta de crédito o débito" <?php if ($metodoPago == 'Tarjeta de crédito o débito') { echo 'checked'; } ?>>
                        <label class="opcion-pago" for="pagoTarjeta">
                            Tarjeta de crédito o débito
                        </label>

                        <!-- inputs de la tarjeta -->
                        <div class="caja-tarjeta mb-2">
                            <div class="mb-2">
                                <input type="text" name="num_tarjeta" class="form-control py-2 px-3" placeholder="Número de tarjeta" maxlength="19" value="<?= $numTarjeta ?>">
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="text" name="caducidad" class="form-control py-2 px-3" placeholder="Caducidad (MM/AA)" maxlength="5" value="<?= $caducidad ?>">
                                </div>
                                <div class="col-6">
                                    <input type="text" name="cvv" class="form-control py-2 px-3" placeholder="Código de seguridad" maxlength="4" value="<?= $cvv ?>">
                                </div>
                            </div>
                        </div>

                        <!-- opcion 2: paypal -->
                        <input class="radio-pago" type="radio" name="metodo_pago" id="pagoPaypal" value="PayPal" <?php if ($metodoPago == 'PayPal') { echo 'checked'; } ?>>
                        <label class="opcion-pago" for="pagoPaypal">
                            PayPal
                        </label>

                        <!-- opcion 3: bizum -->
                        <input class="radio-pago" type="radio" name="metodo_pago" id="pagoBizum" value="Bizum" <?php if ($metodoPago == 'Bizum') { echo 'checked'; } ?>>
                        <label class="opcion-pago" for="pagoBizum">
                            Bizum
                        </label>
                    </div>

                    <!-- boton rojo pagar -->
                    <button type="submit" name="pagar_ahora" class="btn w-100 py-3 text-white fw-bold" style="background-color: #FF424E; border-radius: 6px; font-size: 1rem;">
                        Pagar ahora
                    </button>

                    <div class="mt-3">
                        <a href="index.php?controller=Carrito&action=index" class="text-muted text-decoration-none small">
                            ← Volver a la cesta
                        </a>
                    </div>

                </div>
            </div>

            <!-- LADO DERECHO: RESUMEN OSCURO -->
            <div class="col-12 col-lg-5 text-white py-5 px-4 px-md-5" style="background-color: #222222;">
                <div class="w-100" style="max-width: 440px;">

                    <!-- recorremos los productos del carrito -->
                    <div class="mb-4">
                        <?php foreach ($_SESSION['carrito'] as $item) { ?>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    
                                    <!-- foto pequeña con el circulito de cantidad -->
                                    <div class="position-relative">
                                        <img src="img/webp/<?= $item['imagen'] ?>" alt="<?= $item['nombre'] ?>" class="rounded border border-secondary" style="width: 64px; height: 52px; object-fit: cover;">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary text-white" style="font-size: 0.7rem;">
                                            <?= $item['cantidad'] ?>
                                        </span>
                                    </div>

                                    <!-- nombre y los ingredientes si tiene -->
                                    <div>
                                        <span class="text-uppercase fw-bold d-block" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.15rem; letter-spacing: 0.5px;">
                                            <?= $item['nombre'] ?>
                                        </span>
                                        <?php if (!empty($item['ingredientes'])) { ?>
                                            <span class="text-white-50 d-block" style="font-size: 11px;">
                                                <?php foreach ($item['ingredientes'] as $ing) { ?>
                                                    <?= $ing['nombre'] ?> (x<?= $ing['cantidad'] ?>) 
                                                <?php } ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- precio de esta linea -->
                                <span class="fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.15rem;">
                                    <?= number_format($item['precio'] * $item['cantidad'], 2, ',', '.') ?>€
                                </span>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- caja blanca para poner el codigo de descuento -->
                    <div class="bg-white p-1 rounded d-flex align-items-center mb-2">
                        <input type="text" name="codigo_cupon" class="form-control border-0 shadow-none text-dark" placeholder="Código de descuento" value="<?= $codigoCupon ?>">
                        <button type="submit" name="aplicar_cupon" class="btn text-white fw-bold px-4" style="background-color: #FF424E; border-radius: 5px;">
                            Aplicar
                        </button>
                    </div>

                    <!-- mensaje del cupon -->
                    <?php if ($mensajeCupon != "") { ?>
                        <p class="small mb-3 text-warning">
                            <?= $mensajeCupon ?>
                        </p>
                    <?php } else { ?>
                        <div class="mb-3"></div>
                    <?php } ?>

                    <!-- subtotal -->
                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-white-50">Subtotal</span>
                        <span class="fw-bold"><?= number_format($subtotal, 2, ',', '.') ?>€</span>
                    </div>

                    <!-- si hay descuento lo enseñamos -->
                    <?php if ($descuento > 0) { ?>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-success">
                            <span>Descuento</span>
                            <span class="fw-bold">-<?= number_format($descuento, 2, ',', '.') ?>€</span>
                        </div>
                    <?php } ?>

                    <!-- envio -->
                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <span class="text-white-50">Envío</span>
                        <span class="fw-bold"><?= number_format($envio, 2, ',', '.') ?>€</span>
                    </div>

                    <!-- total -->
                    <div class="d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem;">
                            <?= number_format($total, 2, ',', '.') ?>€
                        </span>
                    </div>
                    <span class="text-white-50 d-block" style="font-size: 12px;">
                        Incluye impuestos
                    </span>

                </div>
            </div>

        </div>
    </form>
</div>