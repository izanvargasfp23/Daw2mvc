<div class="bg-white text-dark py-5" style="min-height: 70vh;">
    <div class="container">

        <!-- enlace volver arriba -->
        <div class="mb-1">
            <a href="index.php?controller=Producto&action=carta" 
               class="text-decoration-none fw-bold text-uppercase" 
               style="color: #FF424E; font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 1px;">
                ← VOLVER A LA CARTA
            </a>
        </div>

        <!-- titulo principal -->
        <h1 class="text-uppercase mb-3" style="font-family: 'Bebas Neue', sans-serif; font-size: 3.5rem; color: #111A23; line-height: 1;">
            CESTA
        </h1>

        <?php if (empty($_SESSION['carrito'])): ?>
            
            <div class="py-5 border-top border-bottom border-dark text-center">
                <p class="fs-5 text-muted mb-4">Tu cesta está vacía ahora mismo.</p>
                <a href="index.php?controller=Producto&action=carta" class="boton-red">
                    VER LA CARTA
                </a>
            </div>

        <?php else: ?>

            <?php 
                $subtotal = 0;
                $totalItems = 0;
                $totalPuntos = 0;

                foreach ($_SESSION['carrito'] as $prod) {
                    $subtotal = $subtotal + ($prod['precio'] * $prod['cantidad']);
                    $totalItems = $totalItems + $prod['cantidad'];

                    // calculamos los puntos VP de cada linea
                    if (isset($prod['tipo']) && $prod['tipo'] == 'menu') {
                        $puntosUnidad = intval($prod['precio'] * 100);
                    } else {
                        $puntosUnidad = 500;
                        if (isset($prod['categoria_id']) && $prod['categoria_id'] == 2) {
                            $puntosUnidad = 1000;
                        }
                        if (isset($prod['categoria_id']) && $prod['categoria_id'] == 3) {
                            $puntosUnidad = 2000;
                        }
                    }

                    $totalPuntos = $totalPuntos + ($puntosUnidad * $prod['cantidad']);
                }
            ?>

            <div class="row g-5">
                
                <!-- COLUMNA IZQUIERDA: LISTA DE PRODUCTOS Y MENÚS -->
                <div class="col-12 col-lg-7">

                    <!-- subtitulo PRODUCTOS encima de la linea negra -->
                    <h2 class="text-uppercase mb-2" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; color: #111A23; letter-spacing: 0.5px;">
                        PRODUCTOS
                    </h2>
                    
                    <div style="border-top: 1px solid #111A23;">
                        
                        <?php foreach ($_SESSION['carrito'] as $i => $item): ?>
                            <?php 
                                // puntos de este articulo concreto
                                if (isset($item['tipo']) && $item['tipo'] == 'menu') {
                                    $vpItem = intval($item['precio'] * 100);
                                } else {
                                    $vpItem = 500;
                                    if (isset($item['categoria_id']) && $item['categoria_id'] == 2) {
                                        $vpItem = 1000;
                                    }
                                    if (isset($item['categoria_id']) && $item['categoria_id'] == 3) {
                                        $vpItem = 2000;
                                    }
                                }
                            ?>

                            <div class="py-4 d-flex align-items-start gap-4" style="border-bottom: 1px solid #111A23;">
                                
                                <!-- foto -->
                                <img src="img/webp/<?= $item['imagen'] ?>" 
                                     alt="<?= $item['nombre'] ?>" 
                                     style="width: 170px; height: 125px; object-fit: cover;">
                                
                                <!-- informacion y botones -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h4 class="text-uppercase mb-0" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.6rem; color: #111A23; letter-spacing: 0.5px;">
                                            <?= $item['nombre'] ?>
                                        </h4>

                                        <a href="index.php?controller=Carrito&action=eliminar&id=<?= $i ?>" 
                                           class="text-muted text-decoration-none small fw-bold" 
                                           title="Quitar de la cesta">
                                            ✕
                                        </a>
                                    </div>

                                    <!-- precio unitario + puntos VP -->
                                    <div class="d-flex align-items-center gap-3 mb-2" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; color: #111A23;">
                                        <span class="fw-bold"><?= number_format($item['precio'], 2, ',', '.') ?>€</span>
                                        
                                        <span class="d-inline-flex align-items-center gap-1 fw-bold" style="color: #FF424E;">
                                            +<?= $vpItem ?>
                                            <!-- si pasaste el icono VP a webp cambia la ruta a img/webp/Valorant_Point.webp -->
                                            <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 15px; height: 15px; filter: invert(1);">
                                        </span>
                                    </div>

                                    <!-- si es un producto, mostramos sus ingredientes -->
                                    <?php if (!empty($item['ingredientes'])): ?>
                                        <p class="text-muted small mb-2">
                                            <?php foreach ($item['ingredientes'] as $ing): ?>
                                                <span class="me-2"><?= $ing['nombre'] ?> (x<?= intval($ing['cantidad']) ?>)</span>
                                            <?php endforeach; ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- si es un menu, mostramos los platos que incluye -->
                                    <?php if (!empty($item['platos'])): ?>
                                        <p class="text-muted small mb-2">
                                            <?= implode(' · ', $item['platos']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- controles + cantidad - y boton EDITAR -->
                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <div class="d-inline-flex align-items-center">
                                            <a href="index.php?controller=Carrito&action=sumar&id=<?= $i ?>" 
                                               class="d-inline-flex align-items-center justify-content-center text-white text-decoration-none fw-bold" 
                                               style="width: 26px; height: 26px; background-color: #111A23; font-size: 16px;">
                                                +
                                            </a>
                                            
                                            <span class="px-3 fw-bold" style="color: #FF424E; font-size: 15px;">
                                                <?= $item['cantidad'] ?>
                                            </span>
                                            
                                            <a href="index.php?controller=Carrito&action=restar&id=<?= $i ?>" 
                                               class="d-inline-flex align-items-center justify-content-center text-white text-decoration-none fw-bold" 
                                               style="width: 26px; height: 26px; background-color: #111A23; font-size: 16px;">
                                                -
                                            </a>
                                        </div>

                                        <!-- boton EDITAR solo para productos individuales -->
                                        <?php if (!isset($item['tipo']) || $item['tipo'] == 'producto'): ?>
                                            <a href="index.php?controller=Producto&action=detalle&id=<?= $item['id'] ?>&edit=<?= $i ?>" 
                                               class="text-uppercase fw-bold text-decoration-none" 
                                               style="color: #111A23; font-family: 'Bebas Neue', sans-serif; font-size: 1rem; letter-spacing: 0.5px;">
                                                EDITAR
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>

                <!-- COLUMNA DERECHA: RESUMEN -->
                <div class="col-12 col-lg-5">
                    <div class="p-4" style="background-color: #ECE8E1;">
                        
                        <h2 class="text-uppercase mb-4" style="font-family: 'Bebas Neue', sans-serif; font-size: 2.5rem; color: #111A23; line-height: 1;">
                            RESUMEN
                        </h2>

                        <!-- subtotal -->
                        <div class="d-flex justify-content-between align-items-center mb-3" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; color: #111A23;">
                            <span>SUBTOTAL (<?= $totalItems ?> ITEMS)</span>
                            <span><?= number_format($subtotal, 2, ',', '.') ?>€</span>
                        </div>

                        <!-- envio -->
                        <div class="d-flex justify-content-between align-items-center mb-3" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; color: #111A23;">
                            <span>ENVIO</span>
                            <span>SE CALCULA EN LA SIGUIENTE PANTALLA</span>
                        </div>

                        <!-- puntos totales -->
                        <div class="d-flex justify-content-between align-items-center pb-3 mb-4" style="border-bottom: 1px solid #8B978F; font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem; color: #111A23;">
                            <span>PUNTOS</span>
                            <span class="d-inline-flex align-items-center gap-1">
                                <?= $totalPuntos ?>
                                <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 16px; height: 16px; filter: invert(1);">
                            </span>
                        </div>

                        <!-- boton tramitar compra -->
                        <form action="index.php?controller=Pedido&action=confirmar" method="POST">
                            <button type="submit" class="boton-red w-100 m-0">
                                TRAMITAR COMPRA
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        <?php endif; ?>

    </div>
</div>