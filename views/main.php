<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant Eats</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Nuestro CSS -->
    <link rel="stylesheet" href="css/styles.css?v=3.1">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Si NO estamos en la pantalla de pagar, enseñamos el menú de arriba -->
    <?php 
    if ($view != "views/proceso_compra.php") {
        include_once("views/header.php");
    }
    ?>

    <!-- Aquí se carga cada página de la web -->
    <main class="flex-grow-1">
        <?php 
        if (isset($view) && file_exists($view)) {
            include_once($view);
        } else {
            echo "<div class='container py-5 text-center'><h3>No se ha encontrado la página.</h3></div>";
        }
        ?>
    </main>

    <!-- Si NO estamos en la pantalla de pagar, enseñamos el footer de abajo -->
    <?php 
    if ($view != "views/proceso_compra.php") {
        include_once("views/footer.php");
    }
    ?>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>