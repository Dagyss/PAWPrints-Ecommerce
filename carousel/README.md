# CarouselJS

**CarouselJS** es una librería de carrusel de imágenes responsiva, liviana y totalmente personalizable, diseñada con un enfoque _mobile first_. Carga dinámicamente las imágenes desde un archivo JSON externo, e incluye soporte para navegación por botones, teclas, miniaturas, swipe en dispositivos táctiles, y una barra de progreso animada.

---

## Características

- Enfoque mobile-first con diseño fluido
- Carga de imágenes dinámica desde `images.json`
- Navegación por:
  - Flechas anterior/siguiente
  - Thumbnails
  - Swipe (pantallas táctiles)
  - Teclas de flecha del teclado
- Efectos de transición: `fade`, `slide`, `zoom`
- Barra de progreso superior configurable
- Completamente responsivo con estilos adaptables por pantalla
- Integración sencilla en cualquier HTML

---

## Instalación

1. Cloná o descargá este repositorio.
2. Asegurate de tener la siguiente estructura de archivos:
   carousel/
   ├── css/
   │ ├── reset.css
   │ └── index.css
   ├── js/
   │ └── carousel.js
   ├── images/
   │ └── (tus imágenes)
   ├── images.json
   └── index.html

---

## Uso

### 1. HTML

Incluí el siguiente bloque HTML en tu archivo `index.html`:

```html
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CarouselJS</title>
    <link rel="stylesheet" href="css/index.css" />
  </head>
  <body>
    <header>
      <h1>Galería de Imágenes</h1>
    </header>

    <div class="carousel">
      <button class="carousel-button prev">&#10094;</button>
      <div class="carousel-images"></div>
      <button class="carousel-button next">&#10095;</button>

      <div id="progress-bar-container">
        <div id="progress-bar"></div>
      </div>

      <div class="carousel-thumbnails"></div>
    </div>

    <section id="info">
      <p>Proyecto desarrollado con JavaScript, CSS y HTML</p>
    </section>

    <footer>
      <p>© 2025 CarouselJS</p>
    </footer>

    <script src="js/carousel.js"></script>
  </body>
</html>
```

### 2. Archivo images.json

Este archivo debe contener un arreglo de rutas a imágenes. Ejemplo:

```
[
  "images/foto1.jpg",
  "images/foto2.jpg",
  "images/foto3.jpg"
]
```

### 3. Personalización

Podés cambiar los efectos de transición modificando la clase de cada imagen en el archivo JS. Los efectos disponibles son:

fade: Fundido suave, hace que la imagen aparezca de forma gradual, desde una opacidad de 0 hasta 1.

slide: Deslizamiento horizontal, hace que la imagen entre desde la derecha (100% hacia la izquierda) hasta su posición normal.

zoom: Acercamiento progresivo, hace que la imagen aparezca con un pequeño “zoom out”, es decir, comienza ampliada (1.2 veces más grande) y se reduce hasta su tamaño natural.

También podés personalizar los colores, el diseño o el comportamiento desde index.css
