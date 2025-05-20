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
        <div class="banner">Publicidad</div>
        <section class="carousel-section">
            <h2>Sugerencias</h2>
            <div class="carousel">
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
            </div>
            <div class="carousel-dots">
                <span>&lt;</span>
                <span class="dot selected"></span>
                <span class="dot"></span>
                <span>&gt;</span>
            </div>
        </section>
        <div class="banner">Publicidad</div>
        
        <section class="carousel-section">
            <h2>Los mas vendidos</h2>
            <div class="carousel">
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                <article class="book-card">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/book.png" alt="Portada del libro">
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
            </div>
            <div class="carousel-dots">
                <span>&lt;</span>
                <span class="dot selected"></span>
                <span class="dot"></span>
                <span>&gt;</span>
            </div>
        </section>
    </main>
    <?php
        require "parts/footer.php";
    ?>

</body>
</html>


