<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant Eats</title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos Propios -->
    <link rel="stylesheet" href="css/styles.css?v=3.1">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- CABECERA DE LA WEB -->
    <?php include_once("views/header.php"); ?>

    <!-- CONTENIDO DINÁMICO DE LA VISTA -->
    <main class="flex-grow-1">
        <?php 
        if (isset($view) && file_exists($view)) {
            include_once($view);
        } else {
            echo "<div class='container py-5 text-center'><h3>No se ha podido cargar el contenido.</h3></div>";
        }
        ?>
    </main>

    <!-- PIE DE PÁGINA -->
    <?php include_once("views/footer.php"); ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>