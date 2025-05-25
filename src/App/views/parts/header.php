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
            <form id="search-form" class="header-search__form" action="/books"  method="get">
            <input id="search-input" name="q" type="search" placeholder="¿Qué estás buscando?" autocomplete="off" />
            <button type="submit" aria-label="Buscar">
                <img src="../icons/magnifying-glass.png" alt="Buscar"/>
            </button>
            </form>
            <ul id="search-history" class="header-search__history"></ul>
        </search>
    
        <section class="header-my-account">
            <button type="button" aria-label="Abrir menú de cuenta">
                <img src="../icons/UserIcon.png" class="icon">
                Mi cuenta
            </button>
            <ul>
                <li><a href="./login.html">Iniciar sesión</a></li>
                <li><a href="./create-account.html">Crear cuenta</a></li>
                <li><a href="./purchase-history.html">Historial de compras</a></li>
                <li><a href="./index.html">Cerrar sesión</a></li>
            </ul>
            <a href="./shopping-cart" class="header-shopping-cart-link">
                <img src="../icons/shopping-cart.png" alt="Carrito de compras" class="icon"/>
            </a>
        </section>
    
        <?php
            require __DIR__ . '/nav.php';
        ?>
    
    </header>