<?php
    $errors = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - PAWPrints</title>
    <link rel="stylesheet" href="./css/login.css">
    <script src="./js/pages/accountMenu.js"></script>
</head>
<body>
    <?php
        require "parts/header.php";
    ?>
    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="#">Mi cuenta</a></li>
                <li>Iniciar sesión</li>
            </ul>
        </nav>
        
        <section class="container login-container">
            <h1>Iniciar sesión</h1>
            <?php if (!empty($errors)): ?>
                <section class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p class="error-text"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>
            <form method="POST" action="/login">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="ej: ejemplo@gmail.com" required>
                
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="ej: contraseña123" required>
                <img src="../icons/close-eye.png" alt="" class="icon-forms">
                
                <button type="submit">Iniciar sesión</button>
            </form>
            <p>
                ¿No tenés cuenta aún? <a href="/create-account">Crear cuenta</a>
            </p>
        </section>
    </main>
    
    <?php
        require "parts/footer.php";
    ?>
</body>
</html>