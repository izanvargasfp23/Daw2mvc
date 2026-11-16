<div class="py-5 d-flex align-items-center justify-content-center" style="min-height: 75vh; background-color: #111923;">
    
    <!-- tarjeta blanca estilo cliente riot -->
    <div class="bg-white text-dark p-4 p-md-5 shadow" style="width: 100%; max-width: 420px; border-radius: 6px;">
        
        <h2 class="text-center fw-bold mb-4" style="font-size: 1.8rem; color: #111A23;">
            Iniciar sesión
        </h2>

        <!-- mensaje si falla el correo o la contraseña -->
        <?php if ($error != ""): ?>
            <div class="alert alert-danger py-2 small text-center mb-3">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=Usuario&action=login" method="POST">
            
            <!-- caja gris de correo electronico -->
            <div class="p-2 px-3 mb-3 rounded-2" style="background-color: #EDEDED;">
                <label class="d-block fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                    CORREO ELECTRÓNICO
                </label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" 
                       class="form-control border-0 bg-transparent p-0 fw-bold shadow-none" 
                       style="color: #111A23; font-size: 0.95rem;" required>
            </div>

            <!-- caja gris de contraseña -->
            <div class="p-2 px-3 mb-4 rounded-2" style="background-color: #EDEDED;">
                <label class="d-block fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                    CONTRASEÑA
                </label>
                <input type="password" name="password" 
                       class="form-control border-0 bg-transparent p-0 fw-bold shadow-none" 
                       style="color: #111A23; font-size: 0.95rem;" required>
            </div>

            <!-- boton cuadrado redondeado rojo con flecha blanca -->
            <div class="text-center my-4">
                <button type="submit" 
                        class="btn text-white d-inline-flex align-items-center justify-content-center shadow-sm" 
                        style="width: 68px; height: 68px; background-color: #FF424E; border-radius: 18px; font-size: 1.8rem;">
                    →
                </button>
            </div>

        </form>

        <!-- enlace abajo para ir al registro -->
        <div class="text-center mt-3">
            <a href="index.php?controller=Usuario&action=registro" 
               class="text-decoration-none fw-bold text-uppercase text-muted" 
               style="font-size: 0.75rem; letter-spacing: 0.8px;">
                CREAR CUENTA
            </a>
        </div>

    </div>

</div>
