<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Libros en venta en PAWPrints. Consulta los libros disponibles en PAWPrints." />
    <meta name="keywords" content="PAWPrints, compra, libros, ebooks, productos" />
    <meta name="author" content="PAWPrints" />
    <link rel="stylesheet" href="./css/book-information.css" />
    <title>Libros - PAWPrints</title>
</head>

<body>

    <?php
    require "parts/header.php";
    ?>

    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="./index.html">Home</a></li>
                <li><a href="./books.html">Libros</a></li>
                <li><span>Libro</span></li>
            </ul>
        </nav>

        <h2>Información</h2>
        <section itemscope itemtype="https://schema.org/Book" class="flex-container">
            <img src="<?= htmlspecialchars($book->fields['imagen']) ?>" alt="Portada del Libro" itemprop="image" />
            <section>
                <h2 itemprop="name" ><?= htmlspecialchars($book->fields['titulo']) ?></h2>
                <p itemprop="author"><?= htmlspecialchars($book->fields['autor']) ?></p>
                <p>
                    <span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="ARS" />
                        <span itemprop="price"><?= number_format($book->fields['precio'], 2, ',', '.') ?></span>
                    </span>
                </p>
                <meta itemprop="productID" content="<?= htmlspecialchars($book->fields['id']) ?>" />

                <fieldset>
                    <legend>Elige el formato:</legend>

                    <input type="radio" id="fisico" name="formato-libro" value="f" checked="checked" />
                    <label for="fisico">Fisico</label>

                    <input type="radio" id="electronico" name="formato-libro" value="e" />
                    <label for="electronico">Electronico</label>
                </fieldset>
                <input type="number" id="cantidad" name="cantidad" placeholder="1" min="1" />
                <input type="button" value="Al carrito" />
            </section>

            <section>
                <h2>descripcion</h2>
                <p>Formato:LIBROS</p>
                <p>Editorial:<?= htmlspecialchars($book->fields['editorial']) ?></p>
                <p>Idioma:Español</p>
                <p>ISBN:9789878121383</p>
                <p>N° Páginas: 496</p>
                <p>Fecha Publicación: xx/xxxx</p>
            </section>

            <section>
                <h2>Sinopsis</h2>
                <p><?= htmlspecialchars($book->fields['descripcion']) ?></p>
            </section>

            <input type="radio" id="fisico" name="formato-libro" value="f" checked="checked" />
            <label for="fisico">Fisico</label>

            <input type="radio" id="electronico" name="formato-libro" value="e" />
            <label for="electronico">Electronico</label>

            </fieldset>
            <input type="number" id="cantidad" name="cantidad" placeholder="1" min="1" />
            <input type="button" value="Al carrito" />
        </section>
    </main>

    <?php
    require "parts/footer.php";
    ?>

</body>

</html>