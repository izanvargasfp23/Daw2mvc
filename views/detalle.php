<div class="container container-carta py-4">

    <!-- BOTÓN VOLVER A CARTA -->
    <div class="mb-4">
        <a href="index.php?controller=Producto&action=carta" class="btn-volver">
            &larr; VOLVER A CARTA
        </a>
    </div>

    <!-- FORMULARIO DE PERSONALIZACIÓN -->
    <form action="index.php?controller=Carrito&action=add" method="POST">
        <input type="hidden" name="producto_id" value="<?= $producto ? $producto->getId() : '1' ?>">

        <div class="row g-4">
            
            <!-- COLUMNA IZQUIERDA: IMAGEN + BOTÓN AÑADIR + ALÉRGENOS -->
            <div class="col-12 col-lg-6">
                <!-- Imagen del Producto -->
                <div class="mb-4">
                    <img src="img/png/<?= $producto ? htmlspecialchars($producto->getImagen()) : 'impacto_fuego.jpg' ?>" 
                         alt="<?= $producto ? htmlspecialchars($producto->getNombre()) : 'Producto' ?>" 
                         class="img-fluid w-100" 
                         style="max-height: 400px; object-fit: cover; border-radius: 4px;">
                </div>

                <!-- Botones de Cantidad Principal y Añadir al Carrito -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="d-inline-flex align-items-center bg-dark border border-secondary">
                        <button type="button" class="btn text-white fw-bold px-3 fs-5" onclick="decrementarCantidadPrincipal()">-</button>
                        <input type="number" id="input-cantidad-principal" name="cantidad" value="1" min="1" class="text-center border-0 bg-transparent text-white fw-bold" style="width: 40px;" readonly>
                        <button type="button" class="btn text-white fw-bold px-3 fs-5" onclick="incrementarCantidadPrincipal()">+</button>
                    </div>
                    
                    <div class="flex-grow-1">
                        <button type="submit" class="boton-red w-100 m-0">
                            AÑADIR AL CARRITO
                        </button>
                    </div>
                </div>

                <!-- ALÉRGENOS MOVIDOS AQUÍ (DEBAJO DEL BOTÓN AÑADIR AL CARRITO) -->
                <?php if (!empty($alergenos)): ?>
                    <div>
                        <span class="d-block mb-2 text-danger fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.1rem; letter-spacing: 1px;">
                            // INFORMACIÓN DE ALÉRGENOS
                        </span>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <?php foreach ($alergenos as $alergeno): ?>
                                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 text-white" 
                                     style="background-color: #111923; border: 1px solid #FF424E; font-size: 13px;"
                                     title="<?= htmlspecialchars($alergeno['nombre']) ?>">
                                    <img src="img/svg/<?= htmlspecialchars($alergeno['icono']) ?>" 
                                         alt="<?= htmlspecialchars($alergeno['nombre']) ?>" 
                                         style="width: 18px; height: 18px; filter: invert(1);">
                                    <span class="fw-bold"><?= htmlspecialchars($alergeno['nombre']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- COLUMNA DERECHA: TITULAR + CAJA DE INGREDIENTES -->
            <div class="col-12 col-lg-6">
                
                <span class="d-block mb-1 text-danger fw-bold" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 1px;">
                    // DETALLE DE PRODUCTO
                </span>
                
                <h1 class="text-white mb-4" style="font-family: 'Bebas Neue', sans-serif; font-size: 3.5rem; line-height: 1;">
                    <?= $producto ? htmlspecialchars($producto->getNombre()) : 'PRODUCTO' ?>
                </h1>

                <!-- CAJA DE INGREDIENTES -->
                <div class="p-4" style="background-color: #111923; border: 1px solid #242e3d; border-radius: 4px;">
                    <h3 class="text-white mb-3" style="font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; letter-spacing: 1px;">
                        INGREDIENTES
                    </h3>

                    <div id="contenedor-ingredientes" class="d-flex flex-column mb-4">
                        <?php if (!empty($ingredientes)): ?>
                            <?php foreach ($ingredientes as $index => $ing): ?>
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-secondary border-opacity-25">
                                    <span class="text-white text-uppercase fw-semibold" style="font-size: 14px;">
                                        <?= htmlspecialchars($ing['nombre']) ?>
                                    </span>
                                    <input type="hidden" name="ingredientes[<?= $index ?>][nombre]" value="<?= htmlspecialchars($ing['nombre']) ?>">
                                    
                                    <div class="d-inline-flex align-items-center bg-dark border border-secondary">
                                        <button type="button" class="btn text-white fw-bold px-2 py-0 fs-5" onclick="cambiarIngrediente(this, -1)">-</button>
                                        <input type="number" name="ingredientes[<?= $index ?>][cantidad]" value="<?= (int)$ing['cantidad'] ?>" min="0" max="5" class="text-center border-0 bg-transparent text-white fw-bold" style="width: 35px;" readonly>
                                        <button type="button" class="btn text-white fw-bold px-2 py-0 fs-5" onclick="cambiarIngrediente(this, 1)">+</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- INPUT PARA INGREDIENTE EXTRA -->
                    <div>
                        <label class="text-white text-uppercase d-block mb-2 fw-semibold" style="font-size: 14px;">
                            AÑADIR INGREDIENTE
                        </label>
                        <div class="d-flex gap-2">
                            <input type="text" id="input-nuevo-ingrediente" class="form-control bg-dark border-secondary text-white rounded-0" placeholder="Ej: Queso parmesano">
                            <button type="button" class="boton-red m-0 py-2 px-3 fs-6" onclick="añadirIngredienteExtra()">
                                AÑADIR
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>

<script>
// 1. Sumar cantidad de arriba
function incrementarCantidadPrincipal() {
    let input = document.getElementById('input-cantidad-principal');
    input.value = parseInt(input.value) + 1;
}
// 2. Restar cantidad de arriba
function decrementarCantidadPrincipal() {
    let input = document.getElementById('input-cantidad-principal');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
// 3. Cambiar cantidad de ingredientes normales de la base de datos
function cambiarIngrediente(btn, cambio) {
    let container = btn.parentElement;
    let input = container.querySelector('input[type="number"]');
    let nuevoValor = parseInt(input.value) + cambio;
    if (nuevoValor >= 0 && nuevoValor <= 5) {
        input.value = nuevoValor;
    }
}

let contadorExtras = 100;
let extrasAñadidos = 0;

// 4. Añadir un ingrediente extra escrito por el usuario
function añadirIngredienteExtra() {
    const input = document.getElementById('input-nuevo-ingrediente');
    const nombre = input.value.trim();

    if (nombre == '') {
        return;
    }

    if (extrasAñadidos >= 3) {
        alert('Solo puedes añadir un máximo de 3 ingredientes extra.');
        return;
    }

    // Creamos la fila
    const contenedor = document.getElementById('contenedor-ingredientes');
    const div = document.createElement('div');
    div.className = 'd-flex align-items-center justify-content-between py-2 border-bottom border-secondary border-opacity-25';

    // Texto con el nombre
    const texto = document.createElement('span');
    texto.className = 'text-white text-uppercase fw-semibold';
    texto.style.fontSize = '14px';
    texto.innerText = nombre;

    // Input oculto para PHP
    const oculto = document.createElement('input');
    oculto.type = 'hidden';
    oculto.name = 'ingredientes[' + contadorExtras + '][nombre]';
    oculto.value = nombre;

    // Input numérico con la cantidad fija en 1
    const num = document.createElement('input');
    num.type = 'number';
    num.name = 'ingredientes[' + contadorExtras + '][cantidad]';
    num.value = 1;
    num.readOnly = true;
    num.className = 'text-center border-0 bg-transparent text-white fw-bold';
    num.style.width = '35px';

    //Boton de borrar ingrediente
    const btnBorrar = document.createElement('button');
    btnBorrar.type = 'button';
    btnBorrar.className = 'btn text-white fw-bold px-2 py-0 fs-5';
    btnBorrar.innerText = '-';
    
    btnBorrar.onclick = function() {
        const cantidadActual = Number(num.value);
        
        // Si está en 1 y le damos a menos, se borra la fila
        if (cantidadActual == 1) {
            contenedor.removeChild(div);
            extrasAñadidos = extrasAñadidos - 1;
        } 
        // Si es mayor que 1 (2, 3, 4, 5), sólo restamos 1
        if (cantidadActual > 1) {
            num.value = cantidadActual - 1;
        }
    };

    // Botón para sumar en el extra
    const btnSumar = document.createElement('button');
    btnSumar.type = 'button';
    btnSumar.className = 'btn text-white fw-bold px-2 py-0 fs-5';
    btnSumar.innerText = '+';
    
    btnSumar.onclick = function() {
        if (Number(num.value) < 5) {
            num.value = Number(num.value) + 1;
        }
    };

    // Caja para agrupar los botones y el número
    const selector = document.createElement('div');
    selector.className = 'd-inline-flex align-items-center bg-dark border border-secondary';
    selector.appendChild(btnBorrar);
    selector.appendChild(num);
    selector.appendChild(btnSumar);

    // Montamos las piezas
    div.appendChild(texto);
    div.appendChild(oculto);
    div.appendChild(selector);

    contenedor.appendChild(div);

    // Limpiamos el texto y contamos
    input.value = '';
    contadorExtras = contadorExtras + 1;
    extrasAñadidos = extrasAñadidos + 1;
}
</script>