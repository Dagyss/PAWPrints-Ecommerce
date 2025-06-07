<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página principal de PAWPrints, librería en línea con sugerencias y libros más vendidos.">
    <meta name="author" content="PAWPrints">
    <title>Inicio | PAWPrints</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <?php
        require "parts/header.php";
    ?>
    
    <main>
        <div id="first-banner"></div>

        <section class="carousel-section">
            <h2>Sugerencias</h2>

            <div class="carousel-wrapper">
                <button class="nav prev">&#10094;</button>

                <div class="books-carousel" id="books-carousel">
                <?php foreach ($books as $book): ?>
                    <article class="book-card" itemscope itemtype="https://schema.org/Book">
                        <figure>
                            <a href="./book?id=<?= htmlspecialchars($book->id) ?>">
                                <?php 
                                    $imagen = (strlen($book->imagen ?? '') > 10) 
                                        ? $book->imagen 
                                        : './icons/book.png';
                                ?>
                                <img src="<?= htmlspecialchars($imagen) ?>" alt="Portada del libro" itemprop="image">                            
                            </a>
                        </figure>
                        <section class="book-card__footer">
                            <h3 itemprop="name">
                                <a href="./book?id=<?= htmlspecialchars($book->id) ?>" itemprop="url">
                                    <?= htmlspecialchars($book->titulo) ?>
                                </a>
                            </h3>
                            <p itemprop="author"><?= htmlspecialchars($book->autor) ?></p>
                            <p>
                                <span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                    <meta itemprop="priceCurrency" content="ARS">
                                    <span itemprop="price"><?= htmlspecialchars($book->precio) ?></span>
                                </span>
                            </p>
                            <button type="button">Comprar</button>
                        </section>
                    </article>
                <?php endforeach; ?>
                </div>

                <button class="nav next">&#10095;</button>
            </div>
        </section>

        <div id="second-banner"></div>

        <section class="carousel-section">
            <h2>Los mas vendidos</h2>

            <div class="carousel-wrapper">
                <button class="nav prev-best-sales">&#10094;</button>

                <div class="books-carousel-best-sales" id="books-carousel-best-sales">
                <?php foreach ($books as $book): ?>
                    <article class="book-card">
                    <figure>
                        <a href="./book?id=<?= htmlspecialchars($book->id) ?>">
                        <?php 
                            $imagen = (strlen($book->imagen ?? '') > 10) 
                                ? $book->imagen 
                                : './icons/book.png';
                        ?>
                        <img src="<?= htmlspecialchars($imagen) ?>" alt="Portada del libro">                            
                        </a>
                    </figure>
                    <section class="book-card__footer">
                        <h3>
                            <a href="./book?id=<?= htmlspecialchars($book->id) ?>">
                                <?= htmlspecialchars($book->titulo) ?>
                            </a>
                        </h3>
                        <p><?= htmlspecialchars($book->autor) ?></p>
                        <p>$<?= htmlspecialchars($book->precio) ?></p>
                        <button type="button">Comprar</button>
                    </section>
                    </article>
                <?php endforeach; ?>
                </div>

                <button class="nav next-best-sales">&#10095;</button>
            </div>
        </section>
    </main>
    <?php
        require "parts/footer.php";
    ?>
    <script type="module">
        import { Carousel } from "./js/libraries/carousel.js";
        new Carousel("#first-banner", {
        images: "./images.json",
        transition: "zoom",
        autoplay: true,
        interval: 4000,
        imagePath: "./images/"
        });

        new Carousel("#second-banner", {
        images: "./images.json",
        transition: "zoom",
        autoplay: true,
        interval: 4000,
        imagePath: "./images/"
        });

    </script>
<script src="./js/pages/homeCarousel.js"></script>
<script src="./js/pages/accountMenu.js"></script>

</body>
</html>