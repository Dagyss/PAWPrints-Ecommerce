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
                <li><a href="/">Home</a></li>
                <li><a href="/books">Libros</a></li>
                <li><span>Libro</span></li>
            </ul>
        </nav>
        <h2>Información</h2>
        <section class="content">
            <section class="book-image">
            <img src="<?= htmlspecialchars($book->fields['imagen']) ?>" alt="Portada del Libro" />
            </section>
            <section>
                <h3 class="book-title"><?= htmlspecialchars($book->fields['titulo']) ?></h3>
                <p class="book-author"><?= htmlspecialchars($book->fields['autor']) ?></p>
                <p class="book-price">Precio: $<?= number_format($book->fields['precio'], 2, ',', '.') ?></p>
                <fieldset>
                    <legend>Elige el formato:</legend>
                
                    <input type="radio" id="fisico" name="formato-libro" value="f" checked="checked"/>
                    <label for="fisico">Fisico</label>
                
                    <input type="radio" id="electronico" name="formato-libro" value="e" />
                    <label for="electronico">Electronico</label>
                </fieldset>
                <input type="number" id="cantidad" name="cantidad"  class="book-quantity" placeholder="1" min="1"/>
    
                <input type="button" class="check-button" value="Al carrito" />
    
            </section>
            <section class="book-description">
                <h3>Descripcion</h3>
                <ul>
                    <li>Formato: LIBROS</li>
                    <li>Editorial: <?= htmlspecialchars($book->fields['editorial']) ?></li>
                    <li>Idioma: Español</li>
                    <li>ISBN: <?= htmlspecialchars($book->fields['isbn']) ?></li>
                    <li>N° Páginas: <?=$book->fields['nro_paginas']?></li>
                    <li>Fecha Publicación: <?= date_format($book->fields['fecha_publicacion'],'d/m/Y')?></li>
                </ul>
            </section>
            <section class="book-sinopsis" >
                <h3>Sinopsis</h3>
                <p><?= htmlspecialchars($book->fields['descripcion'])?></p>
    
            </section>
    </section>

    </main>

    <?php
        require "parts/footer.php";
    ?>
    
</body>

</html>
