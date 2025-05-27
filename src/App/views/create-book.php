<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Libros en venta en PAWPrints. Consulta los libros disponibles en PAWPrints." />
    <meta name="keywords" content="PAWPrints, compra, libros, ebooks, productos" />
    <meta name="author" content="PAWPrints" />
    <script src="./js/components/paw.js"></script>
    <script src="./js/app-loader.js"></script>
    <link rel="stylesheet" href="./css/create-book.css">
    <link rel="stylesheet" href="./css/drag-drop.css">
    <title>Libros - PAWPrints</title>
</head>

<body>

    <?php
    require "parts/header.php";
    ?>

    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="/index">Home</a></li>
                <li><a href="/books">Libros</a></li>
                <li><span>Libro Nuevo</span></li>
            </ul>
        </nav>

        <h2>Formulario de Alta</h2>
        <form action="/save" method="post" class="form-content">
            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="El Gran Gatsby">
                
            <label for="autor">Autor</label>
            <input type="text" id="autor" name="autor" placeholder="F. Scott Fitzgerald">

            <label for="editorial">Editorial</label>
            <input type="text" id="editorial" name="editorial" placeholder="Scribner">

            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="7321794311107">

            <label for="idioma">Idioma</label>
            <select name="idioma" id="idioma">
                <option value="espanol">Español</option>
                <option value="frances">Frances</option>
                <option value="ingles">Ingles</option>
                <option value="portugues">Portugues</option>
                <option value="otro">Otro</option>
            </select>

            <label for="fecha_publicacion">Fecha de Publicacion</label>
            <input type="date" id="fecha_publicacion" name="fecha_publicacion">

            <label for="numero_paginas">Numero de Paginas</label>
            <input type="text" id="numero_paginas" name="numero_paginas" placeholder="100">

            <label for="formato">Formato</label>
            <select name="formato" id="formato">
                <option value="digital">Digital</option>
                <option value="fisico">Fisico</option>
            </select>

            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria">
                <option value="ciencia ficcion">Ciencia Ficcion</option>
                <option value="misterio">Misterio</option>
                <option value="romance">Romance</option>
                <option value="terror">Terror</option>
            </select>

            <label for="precio">Precio</label>
            <input type="text" id="precio" name="precio" placeholder="20.15">

            <label for="sinopsis">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" rows="4" cols="50"></textarea>

            <label for="portada">Portada</label>
                <input type="file" id="portada" name="portada" accept=".jpeg, .jpg, .png" hidden>
                <div class="container-portada">
                    <div class="drop-area">
                        <p>Cargue una imagen de la portada aqui</p>
                    </div>
                    <div class="output-area"></div>
                </div>
            <button type="submit" class="accept-button">Aceptar</button>
        </form>
    </main>

    <?php
    require "parts/footer.php";
    ?>
</body>
</html>