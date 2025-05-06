<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página con informacion de la historia, la mision y servicios ofrecidos a la comunidad local.">
    <meta name="keywords" content="PAWPrints, nosotros, historia, mision, servicios">
    <meta name="author" content="PAWPrints" />
    <link rel="stylesheet" href="./css/about-us.css" />
    <title>Nosotros - PAWPrints</title>
</head>
<body>
    <?php
        require "parts/header.php";
    ?>
    
    <main>
        <nav aria-label="breadcrumb">
            <ul>
                <li><a href="/">Home</a></li>
                <li><span>Nosotros</span></li>
            </ul>
        </nav>
        <h2>Nosotros</h2>
        <section class="flex-container">
            <section>
                <h3>Nuestra Mision</h3>
                <p>En PAWPrints, nuestra misión es fomentar el amor por la lectura y el conocimiento, ofreciendo a nuestra comunidad acceso a una amplia y cuidadosamente seleccionada variedad de libros. Buscamos ser un espacio de encuentro cultural, donde cada lector —desde el más joven hasta el más experimentado— pueda descubrir nuevas ideas, autores y mundos.</p>
            </section>
            <section>
                <h3>Un poco de historia...</h3>
                <p>PAWPrints nació en el año 2000, fruto del sueño de sus fundadores de crear un espacio donde los libros fueran protagonistas y pudieran transformar vidas. Comenzamos como un pequeño local con estanterías modestas, pero con una gran pasión por la literatura y el aprendizaje.
                <p>A lo largo de los años, hemos crecido gracias al apoyo de una comunidad lectora fiel y entusiasta. Hoy, además de ofrecer una variada selección de libros, organizamos actividades culturales, clubes de lectura, presentaciones de autores y espacios para que grandes y chicos se acerquen a la lectura.</p>
                <p>Seguimos creyendo en el poder de los libros para conectar personas, abrir mentes y enriquecer corazones.</p>
            </section>
            <section>
                <h3>Nuestros servicios a la comunidad</h3>
                <p>Nuestra librería ofrece una variedad de servicios orientados a promover la lectura, la educación y la participación ciudadana. Entre ellos se incluyen el préstamo de libros, talleres de lectura y escritura, actividades culturales para todas las edades y espacios acogedores para el estudio y la reflexión. Buscamos ser un punto de encuentro accesible donde la cultura y el conocimiento estén al alcance de toda la comunidad.</p>
            </section>

        </section>
    </main>

    <?php
        require "parts/footer.php";
    ?>
    
</body>
</html>
