<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario para crear una cuenta en PAWPrints">
    <meta name="keywords" content="Registro, Crear cuenta, PAWPrints, Libros">
    <title>Crear Cuenta - PAWPrints</title>
    <link rel="stylesheet" href="./css/create-acount.css">
</head>
<body>
    <?php
        require "parts/header.php";
    ?>

    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="./index.html">Home</a></li>
                <li><a href="./mi-cuenta">Mi cuenta</a></li>
                <li><a href="./login.html">Iniciar sesión</a></li>
                <li>Crear cuenta</li>
            </ul>
        </nav>
        
        <section class="container register-container">
            <h1>Crear cuenta</h1>
            <form action="/register" method="post">
                <label for="full_name">Nombre y apellido</label>
                <input type="text" id="name" name="name" placeholder="ej: Cosme Fulanito" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="ej: email@gmail.com" required>
                
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="ej: contraseña123" required>
                <img src="../icons/close-eye.png" alt="" class="icon-forms icon-password">
                
                <label for="confirm_password">Confirmar contraseña</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="ej: contraseña123" required>
                <img src="../icons/close-eye.png" alt="" class="icon-forms icon-confirm-password">
                
                <button type="submit">Crear cuenta</button>
            </form>
            <p>¿Ya tenés una cuenta? <a href="/login">Iniciar sesión</a></p>
        </section>
    </main>

    <?php
        require "parts/footer.php";
    ?>
    <script src="./js/pages/accountMenu.js"></script>
</body>
</html>