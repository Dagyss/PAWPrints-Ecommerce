<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Libros en venta en PAWPrints. Consulta los libros disponibles en PAWPrints." />
    <meta name="keywords" content="PAWPrints, compra, libros, ebooks, productos" />
    <meta name="author" content="PAWPrints" />
    <link rel="stylesheet" href="./css/books.css" />
    <script type="module" src="./js/pages/Books.js"></script>
    <title>Libros - PAWPrints</title>
</head>

<body>
    <?php require "parts/header.php"; ?>

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
                <form id="form-filtros">
                    <fieldset class="filtro">
                        <legend>Ordenar</legend>
                        <label>Ordenar por:</label>
                        <select id="orden" name="orden">
                            <option value="novedades" selected>Novedades</option>
                            <option value="ofertas">Ofertas</option>
                            <option value="mas_vendidos">Más vendidos</option>
                            <option value="precio_asc">Precio: Menor a mayor</option>
                            <option value="precio_desc">Precio: Mayor a menor</option>
                        </select>
                    </fieldset>

                    <fieldset class="filtro">
                        <legend>Categorías</legend>
                        <ul>
                            <li><label><input type="checkbox" name="categorias[]" value="1"> Ficción</label></li>
                            <li><label><input type="checkbox" name="categorias[]" value="2"> No Ficción</label></li>
                            <li><label><input type="checkbox" name="categorias[]" value="3"> Otros</label></li>
                        </ul>
                    </fieldset>

                    <fieldset class="filtro">
                        <legend>Precio</legend>
                        <label>Desde</label>
                        <input id="precioMin" type="number" name="precio_min" placeholder="$ Precio mínimo">
                        <label>Hasta</label>
                        <input id="precioMax" type="number" name="precio_max" placeholder="$ Precio máximo">
                    </fieldset>

                    <fieldset class="filtro">
                        <legend>Autor</legend>
                        <label>Buscar autor:</label>
                        <input id="autor" type="text" name="autor" placeholder="Buscar autor">
                        <select id="coincidenciasAutor" name="coincidencias_autor[]" multiple aria-label="Autores">
                            <option value="1">Primera coincidencia</option>
                            <option value="2">Segunda coincidencia</option>
                            <option value="3">Tercera coincidencia</option>
                        </select>
                    </fieldset>

                    <fieldset class="filtro">
                        <legend>Idioma</legend>
                        <ul>
                            <li><label><input type="checkbox" name="idiomas[]" value="1"> Inglés</label></li>
                            <li><label><input type="checkbox" name="idiomas[]" value="2"> Español</label></li>
                            <li><label><input type="checkbox" name="idiomas[]" value="3"> Francés</label></li>
                            <li><label><input type="checkbox" name="idiomas[]" value="4"> Otros</label></li>
                        </ul>
                    </fieldset>

                    <fieldset class="filtro">
                        <legend>Formato</legend>
                        <label><input type="checkbox" name="formatos[]" value="ebook"> E-book</label>
                        <label><input type="checkbox" name="formatos[]" value="fisico"> Físico</label>
                    </fieldset>

                    <fieldset class="modos-paginacion filtro">
                        <legend>Modo de paginación</legend>
                        <label><input id="modoTrad" type="radio" name="modo_pag" value="trad" checked> Tradicional</label>
                        <label><input id="modoInf" type="radio" name="modo_pag" value="inf"> Scroll infinito</label>
                    </fieldset>

                    <button type="submit">Aplicar filtros</button>
                </form>
            </search>

            <section class="books" id="listaLibros">
                <!-- JS inyectará los libros aquí -->
            </section>

        </section>

        <nav class="pagination" id="paginador">
            <!-- JS inyectará la paginación aquí -->
        </nav>
    </main>

    <?php require "parts/footer.php"; ?>

</body>

</html>