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
                <button class="button-ordenar" type = "button" aria-label="Abrir menu de Ordenar Por">Ordenar Por</button>
            </section>
            
            <search>
                
                <form>
                    <fieldset>
                        <legend>Ordenar</legend>
                        <label>Ordenar por:</label>
                        <select>
                            <option selected>Novedades</option>
                            <option>Ofertas</option>
                            <option>Más vendidos</option>
                            <option>Precio: Menor a mayor</option>
                            <option>Precio: Mayor a menor</option>
                        </select>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Categorías</legend>
                        <ul>
                            <li><label><input class="hola" type="checkbox"> Ficción</label></li>
                            <li><label><input type="checkbox"> No Ficción</label></li>
                            <li><label><input type="checkbox"> Otros</label></li>
                        </ul>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Precio</legend>
                        <label>Desde</label>
                        <input type="number" placeholder="$ Precio mínimo">
                        <label>Hasta</label>
                        <input type="number" placeholder="$ Precio máximo">
                    </fieldset>
                    
                    <fieldset>
                        <legend>Autor</legend>
                        <label>Buscar autor:</label>
                        <input type="text" placeholder="Buscar autor">
                        <select multiple aria-label="Autores">
                            <option value="coincidencia">Primera coincidencia</option>
                            <option value="coincidencia">Segunda coincidencia</option>
                            <option value="coincidencia">Tercera coincidencia</option>
                        </select>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Idioma</legend>
                        <ul>
                            <li><label><input type="checkbox"> Inglés</label></li>
                            <li><label><input type="checkbox"> Español</label></li>
                            <li><label><input type="checkbox"> Francés</label></li>
                            <li><label><input type="checkbox"> Otros</label></li>
                        </ul>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Formato</legend>
                        <label><input type="checkbox"> E-book</label>
                        <label><input type="checkbox"> Físico</label>
                    </fieldset>
                    
                    <button type="submit">Aplicar filtros</button>
                </form>
                
            </search>
            
            <section class="books">

                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                
                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                
                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                
                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                
                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>

                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                
                <article class="book">
                    <figure>
                        <a href="./book.html">
                            <img src="../icons/libro-ejemplo.jpg" alt="Portada del libro" >
                        </a>
                    </figure>
                    <h3><a href="./book.html">Título</a></h3>
                    <p>Nombre del autor</p>
                    <p>$XXXXX</p>
                    <button type="button">Comprar</button>
                </article>
                
            </section>
        </section>    
        </main>

    <?php
        require "parts/footer.php";
    ?>
    
</body>

</html>
