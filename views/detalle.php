<div class="container container-carta py-4">

    <!-- boton para volver -->
    <div class="mb-4">
        <a href="index.php?controller=Producto&action=carta" class="btn-volver">
            &larr; VOLVER A CARTA
        </a>
    </div>

    <!-- formulario para añadir al carrito -->
    <form action="index.php?controller=Carrito&action=add" method="POST">
        <input type="hidden" name="producto_id" value="<?= $producto->getId() ?>">

        <div class="row g-4">
            
            <!-- COLUMNA IZQUIERDA -->
            <div class="col-12 col-lg-6">
                
                <!-- foto -->
                <div class="mb-4">
                    <img src="img/webp/<?= $producto->getImagen() ?>" 
                         alt="<?= $producto->getNombre() ?>" 
                         class="img-fluid w-100" 
                         style="max-height: 400px; object-fit: cover; border-radius: 4px;">
                </div>

                <!-- descripcion -->
                <?php if ($producto->getDescripcion() != ""): ?>
                    <div class="p-3 mb-4" style="background-color: #111923; border: 1px solid #242e3d; border-radius: 4px;">
                        <span class="d-block mb-1 text-danger fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 1px;">
                            // DESCRIPCIÓN
                        </span>
                        <p class="text-white-50 mb-0 fs-6">
                            <?= $producto->getDescripcion() ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- cantidad y boton de comprar -->
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center bg-dark border border-secondary">
                        <button type="button" class="btn text-white fw-bold px-3 fs-5" onclick="restarProducto()">-</button>
                        <input type="number" id="cantidad_producto" name="cantidad" value="1" min="1" class="text-center border-0 bg-transparent text-white fw-bold" style="width: 40px;" readonly>
                        <button type="button" class="btn text-white fw-bold px-3 fs-5" onclick="sumarProducto()">+</button>
                    </div>
                    
                    <div class="flex-grow-1">
                        <button type="submit" class="boton-red w-100 m-0">
                            AÑADIR AL CARRITO
                        </button>
                    </div>
                </div>

            </div>

            <!-- COLUMNA DERECHA -->
            <div class="col-12 col-lg-6">
                
                <span class="d-block mb-1 text-danger fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 1px;">
                    // DETALLE DE PRODUCTO
                </span>
                
                <h1 class="text-white mb-2" style="font-family: 'Bebas Neue', sans-serif; font-size: 3.5rem; line-height: 1;">
                    <?= $producto->getNombre() ?>
                </h1>

                <!-- puntos que da el producto -->
                <?php 
                    $puntos = 500;
                    if ($producto->getCategoriaId() == 2) {
                        $puntos = 1000;
                    }
                    if ($producto->getCategoriaId() == 3) {
                        $puntos = 2000;
                    }
                ?>
                <div class="d-inline-flex align-items-center gap-2 mb-4 px-3 py-1 bg-dark border border-secondary" style="border-radius: 4px;">
                    <span class="text-white-50 small">¡Ganas</span>
                    <span class="fw-bold text-white">+<?= $puntos ?></span>
                    <img src="img/svg/Valorant_Point.svg" alt="VP" style="width: 16px; height: 16px;">
                    <span class="text-white-50 small">puntos con este pedido!</span>
                </div>

                <!-- alergenos -->
                <?php if (!empty($alergenos)): ?>
                    <div class="mb-4">
                        <span class="d-block mb-2 text-danger fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 1px;">
                            // INFORMACIÓN DE ALÉRGENOS
                        </span>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <?php foreach ($alergenos as $alergeno): ?>
                                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 text-white" 
                                     style="background-color: #111923; border: 1px solid #FF424E; font-size: 13px;">
                                    <img src="img/svg/<?= $alergeno['icono'] ?>" 
                                         alt="<?= $alergeno['nombre'] ?>" 
                                         style="width: 18px; height: 18px; filter: invert(1);">
                                    <span class="fw-bold"><?= $alergeno['nombre'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ingredientes -->
                <div class="p-4" style="background-color: #111923; border: 1px solid #242e3d; border-radius: 4px;">
                    <h3 class="text-white mb-3" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; letter-spacing: 1px;">
                        INGREDIENTES
                    </h3>

                    <div class="d-flex flex-column">
                        <?php if (!empty($ingredientes)): ?>
                            <?php foreach ($ingredientes as $i => $ing): ?>
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-secondary border-opacity-25">
                                    <span class="text-white text-uppercase fw-semibold" style="font-size: 14px;">
                                        <?= $ing['nombre'] ?>
                                    </span>
                                    <input type="hidden" name="ingredientes[<?= $i ?>][nombre]" value="<?= $ing['nombre'] ?>">
                                    
                                    <div class="d-inline-flex align-items-center bg-dark border border-secondary">
                                        <button type="button" class="btn text-white fw-bold px-2 py-0 fs-5" onclick="restarIngrediente(<?= $i ?>)">-</button>
                                        <input type="number" id="ingrediente_<?= $i ?>" name="ingredientes[<?= $i ?>][cantidad]" value="<?= intval($ing['cantidad']) ?>" min="0" max="5" class="text-center border-0 bg-transparent text-white fw-bold" style="width: 35px;" readonly>
                                        <button type="button" class="btn text-white fw-bold px-2 py-0 fs-5" onclick="sumarIngrediente(<?= $i ?>)">+</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<script>
// sumar cantidad del producto
function sumarProducto() {
    var input = document.getElementById('cantidad_producto');
    var numero = parseInt(input.value);
    input.value = numero + 1;
}

// restar cantidad del producto
function restarProducto() {
    var input = document.getElementById('cantidad_producto');
    var numero = parseInt(input.value);
    if (numero > 1) {
        input.value = numero - 1;
    }
}

// sumar un ingrediente
function sumarIngrediente(posicion) {
    var input = document.getElementById('ingrediente_' + posicion);
    var numero = parseInt(input.value);
    if (numero < 5) {
        input.value = numero + 1;
    }
}

// restar un ingrediente
function restarIngrediente(posicion) {
    var input = document.getElementById('ingrediente_' + posicion);
    var numero = parseInt(input.value);
    if (numero > 0) {
        input.value = numero - 1;
    }
}
</script>