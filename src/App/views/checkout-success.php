<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página principal de PAWPrints, librería en línea con sugerencias y libros más vendidos.">
    <meta name="author" content="PAWPrints">
    <title>Inicio | PAWPrints</title>
    <link rel="stylesheet" href="./css/checkout-success.css">
</head>
<body>
    <?php
        require "parts/header.php";
    ?>
    <main class="success-container">
        <h2>¡Compra realizada!</h2>
        <p>Gracias, <?= htmlspecialchars($nombre) ?>. Tu pedido fue recibido exitosamente.</p>
        <a href="/" class="button">Volver al inicio</a>
    </main>
    <?php
        require "parts/footer.php";
    ?>

</body>
</html>