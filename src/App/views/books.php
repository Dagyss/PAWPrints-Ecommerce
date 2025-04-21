<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Libros en venta en PAWPrints. Consulta los libros disponibles en PAWPrints." />
    <meta name="keywords" content="PAWPrints, compra, libros, ebooks, productos" />
    <meta name="author" content="PAWPrints" />
    <link rel="stylesheet" href="./css/books.css" />
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
                <li><span>Libros</span></li>
            </ul>
        </nav>

        <h2>Libros</h2>

        <section class="content">


            <section class="filtros">
                <button class="buttom-filtros" type="button" aria-label="Abrir menú de filtros">Filtrar</button>
                <button class="button-ordenar" type="button" aria-label="Abrir menu de Ordenar Por">Ordenar Por</button>
            </section>

            <search>

                <form method="GET">
                    <fieldset>
                        <legend>Ordenar</legend>
                        <label>Ordenar por:</label>
                        <select name="orden">
                            <option value="novedades" selected>Novedades</option>
                            <option value="ofertas">Ofertas</option>
                            <option value="mas_vendidos">Más vendidos</option>
                            <option value="precio_asc">Precio: Menor a mayor</option>
                            <option value="precio_desc">Precio: Mayor a menor</option>
                        </select>
                    </fieldset>

                    <fieldset>
                        <legend>Categorías</legend>
                        <ul>
                            <li><label><input type="checkbox" name="categorias[]" value="1"> Ficción</label></li>
                            <li><label><input type="checkbox" name="categorias[]" value="2"> No Ficción</label></li>
                            <li><label><input type="checkbox" name="categorias[]" value="3"> Otros</label></li>
                        </ul>
                    </fieldset>

                    <fieldset>
                        <legend>Precio</legend>
                        <label>Desde</label>
                        <input type="number" name="precio_min" placeholder="$ Precio mínimo">
                        <label>Hasta</label>
                        <input type="number" name="precio_max" placeholder="$ Precio máximo">
                    </fieldset>

                    <fieldset>
                        <legend>Autor</legend>
                        <label>Buscar autor:</label>
                        <input type="text" name="autor" placeholder="Buscar autor">
                        <select name="coincidencias_autor[]" multiple aria-label="Autores">
                            <option value="1">Primera coincidencia</option>
                            <option value="2">Segunda coincidencia</option>
                            <option value="3">Tercera coincidencia</option>
                        </select>
                    </fieldset>

                    <fieldset>
                        <legend>Idioma</legend>
                        <ul>
                            <li><label><input type="checkbox" name="idiomas[]" value="1"> Inglés</label></li>
                            <li><label><input type="checkbox" name="idiomas[]" value="2"> Español</label></li>
                            <li><label><input type="checkbox" name="idiomas[]" value="3"> Francés</label></li>
                            <li><label><input type="checkbox" name="idiomas[]" value="4"> Otros</label></li>
                        </ul>
                    </fieldset>

                    <fieldset>
                        <legend>Formato</legend>
                        <label><input type="checkbox" name="formatos[]" value="ebook"> E-book</label>
                        <label><input type="checkbox" name="formatos[]" value="fisico"> Físico</label>
                    </fieldset>

                    <button type="submit">Aplicar filtros</button>
                </form>

            </search>

            <section class="books">

                <?php if (empty($books)): ?>
                    <section class = "no_content">
                        <img src="../icons/no_content.png" alt="No hay libros">
                        <p> No se encontraron libros </p>
                    </section>
                <?php endif; ?>

                <?php foreach ($books as $book): ?>
                    <article class="book">
                        <figure>
                            <a href="./book.php?id=<?= htmlspecialchars($book->fields['id']) ?>">
                                <img src="<?= htmlspecialchars($book->fields['imagen']) ?>" alt="Portada del libro">
                            </a>
                        </figure>
                        <h3>
                            <a href="./book.php?id=<?= htmlspecialchars($book->fields['id']) ?>">
                                <?= htmlspecialchars($book->fields['titulo']) ?>
                            </a>
                        </h3>
                        <p><?= htmlspecialchars($book->fields['autor']) ?></p>
                        <p>$<?= number_format($book->fields['precio'], 2, ',', '.') ?></p>
                        <button type="button">Comprar</button>
                    </article>
                <?php endforeach; ?>
            </section>
        </section>
        <nav class="pagination">
            <?php if ($paginaActual > 1): ?>
                <a href="?page=<?= $paginaActual - 1 ?>&size=<?= $librosPorPagina ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $paginaActual): ?>
                    <strong><?= $i ?></strong>
                <?php else: ?>
                    <a href="?page=<?= $i ?>&size=<?= $librosPorPagina ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <a href="?page=<?= $paginaActual + 1 ?>&size=<?= $librosPorPagina ?>">&gt;</a>
            <?php endif; ?>
        </nav>
    </main>

    <?php
    require "parts/footer.php";
    ?>

</body>

</html>