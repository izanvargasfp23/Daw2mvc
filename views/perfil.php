<div class="container container-carta my-4 py-3">

    <!-- cabecera del perfil con nombre y saldo VP -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
        <div>
            <span class="d-block text-danger fw-bold titulo fs-5">
                // EXPEDIENTE DE AGENTE
            </span>
            <h1 class="text-white text-uppercase display-4 m-0">
                <?= htmlspecialchars($usuario['nombre']) ?>
            </h1>
        </div>

        <!-- saldo de puntos VP del usuario -->
        <div class="tarjeta-perfil px-4 py-2 text-center">
            <span class="d-block text-white-50 small text-uppercase">Saldo disponible</span>
            <span class="titulo text-danger fs-3 fw-bold">
                <?= intval($usuario['puntos']) ?> VP
            </span>
        </div>
    </div>

    <!-- mensaje de confirmacion o error -->
    <?php if ($mensajeCanje != ""): ?>
        <div class="alert alert-info py-2 small mb-4">
            <?= htmlspecialchars($mensajeCanje) ?>
        </div>
    <?php endif; ?>

    <!-- 1. DATOS DEL AGENTE -->
    <div class="tarjeta-perfil p-4 mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h3 class="text-white text-uppercase m-0">
                DATOS DEL AGENTE
            </h3>

            <button type="button" class="boton-red m-0" data-bs-toggle="collapse" data-bs-target="#cajaEditarDatos">
                EDITAR DATOS
            </button>
        </div>

        <div class="row g-3 text-white">
            <div class="col-12 col-md-4">
                <span class="d-block text-white-50 small text-uppercase">Correo electrónico</span>
                <span class="fw-semibold"><?= htmlspecialchars($usuario['email']) ?></span>
            </div>

            <div class="col-12 col-md-4">
                <span class="d-block text-white-50 small text-uppercase">Teléfono</span>
                <span class="fw-semibold">
                    <?php 
                    if (!empty($usuario['telefono'])) {
                        echo htmlspecialchars($usuario['telefono']);
                    } else {
                        echo "No especificado";
                    }
                    ?>
                </span>
            </div>

            <div class="col-12 col-md-4">
                <span class="d-block text-white-50 small text-uppercase">Dirección habitual</span>
                <span class="fw-semibold">
                    <?php 
                    if (!empty($usuario['direccion'])) {
                        echo htmlspecialchars($usuario['direccion']);
                    } else {
                        echo "Se guardará en tu primer pedido";
                    }
                    ?>
                </span>
            </div>
        </div>

        <!-- formulario oculto para editar los datos -->
        <div class="collapse mt-4 pt-3 border-top border-secondary border-opacity-25" id="cajaEditarDatos">
            <form action="index.php?controller=Usuario&action=editarPerfil" method="POST" class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label text-white-50 small text-uppercase">Nombre de agente</label>
                    <input type="text" name="nombre" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label text-white-50 small text-uppercase">Teléfono</label>
                    <input type="text" name="telefono" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label text-white-50 small text-uppercase">Dirección habitual</label>
                    <input type="text" name="direccion" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?= htmlspecialchars($usuario['direccion'] ?? '') ?>">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label text-white-50 small text-uppercase">Correo electrónico</label>
                    <input type="email" name="email" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label text-white-50 small text-uppercase">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Dejar vacío para no cambiar">
                </div>

                <div class="col-12 col-md-4 d-flex justify-content-end gap-2">
                    <button type="button" class="boton-negro m-0" data-bs-toggle="collapse" data-bs-target="#cajaEditarDatos">
                        CANCELAR
                    </button>
                    <button type="submit" class="boton-red m-0">
                        GUARDAR CAMBIOS
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. OFERTAS Y RECOMPENSAS VP -->
    <div class="tarjeta-perfil p-4 mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <h3 class="text-white text-uppercase m-0">
                RECOMPENSAS Y OFERTAS VP
            </h3>
            <span class="text-white-50 small">
                Acumula VP con cada plato y menú táctico
            </span>
        </div>

        <!-- tarjetas de ofertas disponibles -->
        <div class="row g-3 mb-4">
            <?php foreach ($ofertasDisponibles as $of): ?>
                <?php 
                $puedeCanjear = false;
                if (intval($usuario['puntos']) >= intval($of['puntos_coste'])) {
                    $puedeCanjear = true;
                }
                ?>
                <div class="col-12 col-md-4">
                    <div class="border border-secondary border-opacity-25 rounded-2 p-3 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge bg-danger mb-2">
                                <?= intval($of['puntos_coste']) ?> VP
                            </span>
                            <h5 class="text-white text-uppercase mb-1">
                                <?= htmlspecialchars($of['nombre']) ?>
                            </h5>
                            <p class="text-white-50 small mb-3">
                                <?= htmlspecialchars($of['descripcion']) ?>
                            </p>
                        </div>

                        <?php if ($puedeCanjear): ?>
                            <a href="index.php?controller=Usuario&action=canjear&id=<?= $of['id'] ?>" class="btn btn-valorant w-100">
                                CANJEAR OFERTA
                            </a>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary w-100" disabled>
                                TE FALTAN <?= intval($of['puntos_coste']) - intval($usuario['puntos']) ?> VP
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- codigos ya canjeados por este usuario -->
        <?php if (!empty($ofertasCanjeadas)): ?>
            <h5 class="text-white text-uppercase mb-2 pt-3 border-top border-secondary border-opacity-25">
                MIS CÓDIGOS DESBLOQUEADOS (ÚSALOS AL PAGAR)
            </h5>
            <div class="table-responsive">
                <table class="table table-dark table-sm align-middle mb-0">
                    <thead>
                        <tr class="text-white-50 small text-uppercase">
                            <th>Oferta</th>
                            <th>Descuento</th>
                            <th>Código para el carrito</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ofertasCanjeadas as $canj): ?>
                            <tr>
                                <td class="text-white"><?= htmlspecialchars($canj['nombre']) ?></td>
                                <td class="text-white-50"><?= intval($canj['valor']) ?>%</td>
                                <td>
                                    <span class="badge bg-warning text-dark fs-6">
                                        <?= htmlspecialchars($canj['codigo']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- 3. HISTORIAL DE PEDIDOS -->
    <div class="tarjeta-perfil p-4">
        <h3 class="text-white text-uppercase mb-3">
            MIS PEDIDOS REALIZADOS
        </h3>

        <?php if (empty($pedidos)): ?>
            <p class="text-white-50 mb-3">
                Todavía no has realizado ningún pedido con esta cuenta.
            </p>
            <a href="index.php?controller=Producto&action=carta" class="boton-red m-0">
                VER LA CARTA
            </a>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-white-50 small text-uppercase">
                            <th>Pedido</th>
                            <th>Fecha</th>
                            <th>Pago</th>
                            <th>Estado</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $ped): ?>
                            <tr>
                                <td class="fw-bold text-white">#<?= $ped['id'] ?></td>
                                <td class="text-white-50 small">
                                    <?= date("d/m/Y H:i", strtotime($ped['fecha_pedido'])) ?>
                                </td>
                                <td class="small"><?= htmlspecialchars($ped['metodo_pago']) ?></td>
                                <td>
                                    <span class="badge bg-success text-uppercase">
                                        <?= htmlspecialchars($ped['estado']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-danger">
                                    <?= number_format($ped['total'], 2, ',', '.') ?>€
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>