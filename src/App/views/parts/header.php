<header id="header">
        <input type="checkbox" id="hamburger-checkbox" class="hamburger-checkbox">
        <label for="hamburger-checkbox" class="hamburger-menu">
            <img src="../icons/hamburguer-menu.png" alt="Menú" class="icon">
        </label>
        <h1>
            <a href="./home.html">
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
            <a href="./shopping-cart.html" class="header-shopping-cart-link">
                <img src="../icons/shopping-cart.png" alt="Carrito de compras" class="icon"/>
            </a>
        </section>
    
        <?php
            require __DIR__ . '/nav.php';
        ?>
    
    </header>