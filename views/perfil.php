<div class="container container-carta my-4">

    <!-- cabecera de arriba con el nombre y los puntos VP que tiene -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary">
        <div>
            <p class="text-danger fw-bold mb-0">MI PERFIL</p>
            <h1 class="text-white text-uppercase display-5 mb-0">
                <?php echo $usuario['nombre']; ?>
            </h1>
        </div>

        <!-- cajita con los puntos acumulados -->
        <div class="tarjeta-perfil px-4 py-2 text-center">
            <small class="text-white-50 d-block">Mis puntos</small>
            <span class="text-danger fs-3 fw-bold">
                <?php echo $usuario['puntos']; ?> VP
            </span>
        </div>
    </div>

    <!-- si venimos de canjear algo o editar datos, aqui sale el aviso -->
    <?php if ($mensajeCanje != "") { ?>
        <div class="alert alert-info py-2 mb-4">
            <?php echo $mensajeCanje; ?>
        </div>
    <?php } ?>

    <!-- BLOQUE 1: DATOS PERSONALES DEL USUARIO -->
    <div class="tarjeta-perfil p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-white m-0">MIS DATOS</h3>

            <!-- este boton de bootstrap abre y cierra el formulario de abajo -->
            <button type="button" class="boton-red m-0" data-bs-toggle="collapse" data-bs-target="#cajaEditarDatos">
                EDITAR DATOS
            </button>
        </div>

        <div class="row text-white">
            <div class="col-md-4 mb-2">
                <small class="text-white-50 d-block">Correo</small>
                <strong><?php echo $usuario['email']; ?></strong>
            </div>

            <div class="col-md-4 mb-2">
                <small class="text-white-50 d-block">Teléfono</small>
                <strong>
                    <?php 
                    if ($usuario['telefono'] != "") {
                        echo $usuario['telefono'];
                    } else {
                        echo "Sin teléfono";
                    }
                    ?>
                </strong>
            </div>

            <div class="col-md-4 mb-2">
                <small class="text-white-50 d-block">Dirección de entrega</small>
                <strong>
                    <?php 
                    // juntamos calle, cp y ciudad en una sola linea para verlo facil
                    if ($usuario['direccion'] != "") {
                        echo $usuario['direccion'] . ", " . $usuario['cp'] . " " . $usuario['ciudad'];
                    } else {
                        echo "Aún no has guardado dirección";
                    }
                    ?>
                </strong>
            </div>
        </div>

        <!-- formulario oculto que se despliega al darle a Editar datos -->
        <div class="collapse mt-4 pt-3 border-top border-secondary" id="cajaEditarDatos">
            <form action="index.php?controller=Usuario&action=editarPerfil" method="POST" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-white-50 small">Nombre</label>
                    <input type="text" name="nombre" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?php echo $usuario['nombre']; ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-white-50 small">Correo</label>
                    <input type="email" name="email" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?php echo $usuario['email']; ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-white-50 small">Teléfono</label>
                    <input type="text" name="telefono" class="form-control form-control-sm bg-dark text-white border-secondary" value="<?php echo $usuario['telefono']; ?>">
                </div>

                <?php
                // juntamos los 3 campos separados por comas para enseñarlos en una sola caja
                $direccionJunta = "";
                if ($usuario['direccion'] != "") {
                    $direccionJunta = $usuario['direccion'] . ", " . $usuario['cp'] . ", " . $usuario['ciudad'];
                }
                ?>
                <div class="col-md-4">
                    <label class="form-label text-white-50 small">Dirección (Calle, CP, Ciudad)</label>
                    <input type="text" name="direccion_completa" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Ej: Calle Mayor 12, 08750, Molins de Rei" value="<?php echo $direccionJunta; ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label text-white-50 small">Nueva contraseña (opcional)</label>
                    <input type="password" name="password" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Déjalo vacío si no la quieres cambiar">
                </div>

                <div class="col-md-4 d-flex justify-content-end align-items-end gap-2">
                    <button type="button" class="boton-negro m-0" data-bs-toggle="collapse" data-bs-target="#cajaEditarDatos">
                        CANCELAR
                    </button>
                    <button type="submit" class="boton-red m-0">
                        GUARDAR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- BLOQUE 2: OFERTAS PARA CANJEAR CON PUNTOS -->
    <div class="tarjeta-perfil p-4 mb-4">
        <h3 class="text-white mb-1">CANJEAR PUNTOS VP</h3>
        <p class="text-white-50 small mb-3">Gasta tus puntos para conseguir códigos de descuento.</p>

        <!-- recorremos todas las ofertas activas de la base de datos -->
        <div class="row g-3 mb-4">
            <?php foreach ($ofertasDisponibles as $of) { ?>
                <div class="col-md-4">
                    <div class="border border-secondary rounded p-3 h-100">
                        <span class="badge bg-danger mb-2"><?php echo $of['puntos_coste']; ?> VP</span>
                        <h5 class="text-white"><?php echo $of['nombre']; ?></h5>
                        <p class="text-white-50 small"><?php echo $of['descripcion']; ?></p>

                        <!-- comprobamos si le llegan los puntos para activar el boton -->
                        <?php if ($usuario['puntos'] >= $of['puntos_coste']) { ?>
                            <a href="index.php?controller=Usuario&action=canjear&id=<?php echo $of['id']; ?>" class="btn btn-valorant w-100">
                                CANJEAR
                            </a>
                        <?php } else { ?>
                            <button type="button" class="btn btn-secondary w-100" disabled>
                                Te faltan <?php echo $of['puntos_coste'] - $usuario['puntos']; ?> VP
                            </button>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- tabla con los codigos que ya tiene canjeados y sin usar -->
        <?php if (count($ofertasCanjeadas) > 0) { ?>
            <h5 class="text-white pt-3 border-top border-secondary">
                MIS CÓDIGOS SIN USAR (ponlos al pagar)
            </h5>
            <table class="table table-dark table-sm mt-2 mb-0">
                <thead>
                    <tr class="text-white-50 small">
                        <th>Oferta</th>
                        <th>Descuento</th>
                        <th>Código</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ofertasCanjeadas as $canj) { ?>
                        <tr>
                            <td><?php echo $canj['nombre']; ?></td>
                            <td><?php echo intval($canj['valor']); ?>%</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <?php echo $canj['codigo']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <!-- BLOQUE 3: PEDIDOS QUE HA HECHO EL USUARIO -->
    <div class="tarjeta-perfil p-4">
        <h3 class="text-white mb-3">MIS PEDIDOS</h3>

        <?php if (count($pedidos) == 0) { ?>
            <p class="text-white-50">Todavía no has pedido nada.</p>
            <a href="index.php?controller=Producto&action=carta" class="boton-red m-0">
                IR A LA CARTA
            </a>
        <?php } else { ?>
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr class="text-white-50 small">
                        <th>Nº Pedido</th>
                        <th>Fecha</th>
                        <th>Método de pago</th>
                        <th>Estado</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $ped) { ?>
                        <tr>
                            <td class="fw-bold">#<?php echo $ped['id']; ?></td>
                            <td class="text-white-50 small">
                                <?php echo date("d/m/Y H:i", strtotime($ped['fecha_pedido'])); ?>
                            </td>
                            <td class="small"><?php echo $ped['metodo_pago']; ?></td>
                            <td>
                                <span class="badge bg-success"><?php echo $ped['estado']; ?></span>
                            </td>
                            <td class="text-end fw-bold text-danger">
                                <?php echo number_format($ped['total'], 2, ',', '.'); ?>€
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

</div>