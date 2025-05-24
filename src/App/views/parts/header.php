<?php
    $loggedUser = $_SESSION['user'] ?? null;
?>
<header id="header">
    <input type="checkbox" id="hamburger-checkbox" class="hamburger-checkbox">
    <label for="hamburger-checkbox" class="hamburger-menu">
        <img src="../icons/hamburguer-menu.png" alt="Menú" class="icon">
    </label>
    <h1>
        <a href="./">
            PAWPrints
            <img src="../icons/PAWPrintsWhite.svg" id="enterprise-icon"/>
        </a>
    </h1>

    <search class="header-search">
        <form class="header-search__form">
            <input type="search" placeholder="¿Qué estás buscando?" />
            <button type="submit" aria-label="Buscar">
                <img src="../icons/magnifying-glass.png" alt="Buscar"/>
            </button>
        </form>
    </search>

    <section class="header-my-account">
        <button type="button" aria-label="Abrir menú de cuenta" id="account-button">
            <?php
                $avatarSrc = '../icons/UserIcon.png';
                if (isset($loggedUser) && !empty($loggedUser['avatar'])) {
                    $avatarSrc = $loggedUser['avatar'];
                }
            ?>
            <img src="<?= $avatarSrc ?>" class="icon" alt="Avatar">
            <?= $loggedUser ? htmlspecialchars($loggedUser['username']) : 'Mi cuenta' ?>
        </button>
         <ul id="account-menu">
            <?php if ($loggedUser): ?>
                <li><a href="/purchase-history">Historial de compras</a></li>
                <li><a href="/logout">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="/login">Iniciar sesión</a></li>
                <li><a href="/create-account">Crear cuenta</a></li>
            <?php endif; ?>
        </ul>
        <a href="./shopping-cart" class="header-shopping-cart-link">
            <img src="../icons/shopping-cart.png" alt="Carrito de compras" class="icon"/>
        </a>
    </section>

    <?php
        require __DIR__ . '/nav.php';
    ?>

</header>