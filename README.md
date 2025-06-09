# TP5 - programación backend 2

## Estructura del Proyecto PawPrint

```bash
.
├── public/
│   ├── icons/
│   ├── css/
│   ├── js/
│   └── index.php
├── src/
│   ├── App/
│   │   ├── Controller/
│   │   ├── Views/
│   │   │   ├── Parts/
│   ├── Config/
│   │   ├── config.php
│   ├── Core/
│   │   ├── Exceptions/
│   │   ├── Router.php
│   ├── Models/
│   └── bootstrap.php
├── storage/
├── .env
└── composer.json
```

## Análisis de peticiones HTTP

Responsable: index.php + Router (Core/Router.php)

Descripción: El archivo public/index.php actúa como Front Controller. Toma la URL solicitada por el navegador ($\_SERVER['REQUEST_URI']) y la pasa al enrutador (Router) para determinar qué controlador debe manejarla.

## Mapeo de URLs en funcionalidades

Responsable: Router (Core/Router.php)

Descripción: Mapea rutas como /books o /about-us con métodos de controladores (PageController@books).

## Generación de respuestas HTTP

Responsable: Controladores (App/Controllers/_.php) + Vistas (App/Views/_.php)

Descripción: Cada controlador se encarga de procesar la lógica de la solicitud y retornar una vista (HTML, PDF, etc.). Además, puede establecer códigos HTTP como http_response_code(404).

## Generación de registros

Responsable: bootstrap.php + Monolog

Descripción: Se utiliza Monolog para registrar errores, info de rutas, excepciones no capturadas, etc. Ideal para debug en desarrollo.

## Persistencia

Responsable: Modelos (App/Models/\*.php) y un posible Database en Core/

Descripción: Se creó una base de datos mysql en docker

## Configuración

Responsable: Archivo src/Config/config.php

Descripción: La configuración central se debe almacenar en un lugar único. Ahí van las rutas de logs, entorno (DEBUG, PRODUCTION), rutas a recursos, etc.

## Diferentes representaciones de la información

Responsable: Controladores + Vistas + Librerías externas

Descripción:

- HTML → Views/\*.php
- JSON → echo json_encode($data);

## Tecnologías y Herramientas

- PHP >= 7.4.3
- Composer para gestión de dependencias
- Sistema de logs ubicado en `/Logs/logs.app`

## Instrucciones de uso

1. Clonar el repositorio

```bash
git clone https://github.com/Dagyss/PAWPrints-Ecommerce.git
```

2. Levantar el proyecto localmente

```bash
cd ~/PAWPrints-Ecommerce
make up
```

Esto iniciará un servidor PHP local en `http://localhost:9999`, sirviendo desde el directorio `public/`.

## 6- ¿Qué es un ataque de inyección SQL? ¿Cómo puede evitarse? Realice las modificaciones necesarias en su aplicación para protegerse de dichos ataques.

Un ataque de inyección sql ocurre cuando un usuario malintencionado aprovecha los campos de entrada de una aplicación (como formularios o URLs) para insertar código sql arbitrario. El objetivo suele ser manipular la base de datos, ya sea para robar información, modificarla o incluso eliminarla. Esto puede pasar, por ejemplo, cuando una consulta sql se construye directamente con datos que vienen del usuario, sin filtrarlos ni validarlos correctamente.

Para evitar este tipo de ataques, lo más importante es no concatenar directamente los valores que vienen del usuario dentro de las consultas sql. En su lugar, se deben usar consultas preparadas o "queries parametrizadas", que permiten separar el código sql de los datos.

En nuestra app hicimos las siguientes modificaciones para protegernos:

Reemplazamos las consultas construidas manualmente con strings por consultas parametrizadas utilizando el ORM php.

Validamos y sanitizamos las entradas del usuario donde era necesario.

En los formularios, implementamos validaciones tanto del lado del cliente como del servidor para asegurarnos de que los datos tengan el formato esperado.

De esta manera, nos aseguro de que cualquier dato que llegue desde el usuario no pueda ser interpretado como parte del código sql y, por lo tanto, no tenga forma de alterar la lógica de las consultas.

### Ejemmplo de nuestro código:

```bash
    private PDO $pdo;
    private function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            $pdo = Database::getConnection();
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function select(
        $table,
        array $params = [],
        ?string $orderBy = null,
        ?string $direction = 'ASC',
        ?int $limit = null,
        ?int $offset = null
    ) {
        $query = "SELECT * FROM {$table}";
        $values = [];

        if (!empty($params)) {
            $conditions = [];
            foreach ($params as $field => $value) {
                $conditions[] = "$field = ?";
                $values[] = $value;
            }
            $query .= " WHERE " . implode(" AND ", $conditions);
        } else {
            $query .= " WHERE 1=1";
        }

        if ($orderBy) {
            $query .= " ORDER BY {$orderBy} {$direction}";
        }

        if ($limit !== null) {
            $query .= " LIMIT {$limit}";
            if ($offset !== null) {
                $query .= " OFFSET {$offset}";
            }
        }
        $statement = $this->pdo->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($values);

        return $statement->fetchAll();
    }
```

## 7- ¿Qué implica un ataque XSS? ¿Cómo puede evitarse?

Un ataque **Cross-Site Scripting (XSS)** es una vulnerabilidad de seguridad que permite a un atacante inyectar código malicioso en aplicaciones web. Este código, generalmente en JavaScript, puede ejecutarse en el navegador de la víctima, comprometiendo la seguridad de sus datos y sesiones.

Los ataques XSS pueden clasificarse en tres tipos principales:

- **Reflejado:** Se ejecuta cuando el usuario hace clic en un enlace manipulado.
- **Almacenado:** Se guarda en el servidor y afecta a múltiples usuarios cuando cargan la página comprometida.
- **DOM-based:** Se aprovecha de modificaciones del DOM en el navegador para ejecutar el código malicioso.

### Prevención y cambios aplicados

1. **Encabezado CSP** En el archivo `src/bootstrap.php` se agrega el siguiente encabezado:

   ```php
   header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data: https://covers.openlibrary.org https://images.cdn3.buscalibre.com https://archive.org https://*.archive.org https://proassetspdlcom.cdnstatics2.com https://http2.mlstatic.com https://lavenamisteriosa.com https://images.cdn1.buscalibre.com; font-src 'self' https://fonts.gstatic.com; object-src 'none'; frame-ancestors 'self'; base-uri 'self'");
   ```

1. **Auto-escape en Twig**  
    En `src/bootstrap.php`:

   ```php
   $twig = new Environment($loader, [
    'cache' => false,
    'debug' => DEBUG,
    'autoescape' => 'html'
   ]);
   ```

1. **Escape explícito en plantillas `.twig`**  
   Todos los datos dinámicos van con `|e`. Ejemplos en `src/templates/book.twig`:

   ```diff
   -<p>{{ book.fields.descripcion }}</p>
   +<p>{{ book.fields.descripcion|e }}</p>

   -<a href="./book?id={{ book.fields.id }}">
   +<a href="./book?id={{ book.fields.id|e }}">
   ```

   Y en `src/templates/checkout-form.twig` los errores y valores previos:

   ```twig
   {% for error in errors %}
     <li>{{ error|e }}</li>
   {% endfor %}
   <input value="{{ data.nombre|default('')|e }}">
   ```

1. **Sanitización y validación en controladores PHP**

   - **BooksController::save()**:
     ```php
     $titulo = filter_var(trim($_POST['titulo'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $precio = isset($_POST['precio']) ? (float) $_POST['precio'] : 0.0;
     $fechaPub = $_POST['fecha_publicacion'] ?? '';
     if ($fechaPub && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaPub)) {
         throw new Exception('Fecha inválida');
     }
     ```
   - **AuthController::register()**:
     ```php
     $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errors[] = 'Email no válido';
     }
     ```
   - **CheckoutController::submit()**:
     ```php
     $data['nombre']   = filter_var(trim($request->post('nombre')), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $data['telefono'] = preg_replace('/[^\d\+]/', '', $request->post('telefono'));
     $data['entrega']  = in_array($request->post('entrega'), ['domicilio','sucursal'], true)
                        ? $request->post('entrega')
                        : 'domicilio';
     ```

1. **Buenas prácticas en JavaScript**  
   Dentro de `public/js/components/BookComponent.js` usamos `textContent` y `encodeURIComponent` para URLs:

   ```js
   linkTitle.href = `./book?id=${encodeURIComponent(book.id)}`;
   linkTitle.textContent = book.titulo;

   const pAuthor = document.createElement("p");
   pAuthor.textContent = book.autor;
   ```

Implementando estos cambios — **CSP**, **sanitización**, **validación** y **escape de salida** — Tenemos la APP protegída contra ataques XSS.

## 9- Implementar las funcionalidades necesarias para que cada página tenga la microdata que corresponda.

## a- ¿Toda la microdata es estática?

## b- ¿Cómo decidimos en qué página es importante la microdata de ciertos objetos? Por ejemplo, ¿En todos los sitios pondremos la microdata de la/s sucursal/es? En los listados de libros, ¿Que tipo de objetos son? ¿Son libros, son publicidades, que son?

Para mejorar el SEO y la comprensión de nuestro sitio por parte de los motores de búsqueda, implementamos microdata en distintas páginas del sistema, utilizando las especificaciones de Schema.org. Esta microdata permite etiquetar ciertos elementos del contenido (como productos, autores, direcciones, etc.) para que puedan ser interpretados de forma semántica.
Por otra parte, no, la microdata no necesariamente es estática. Puede ser dinámica, dependiendo del contenido que se renderice en cada página. Por ejemplo, si tenemos un sistema que lista libros como en nuesto caso, desde una base de datos, la microdata se genera dinámicamente con cada libro que aparece en el listado. En cambio, si tenemos una sección con información fija de una sucursal, como dirección y horario, esa microdata podría ser estática, ya que no cambia frecuentemente.

La microdata se coloca en función del tipo de contenido que tiene valor semántico y que queremos destacar para buscadores o asistentes inteligentes. Por ejemplo:
En una página de detalle de producto, usamos itemtype="https://schema.org/Book" si se trata de un libro, y marcamos título, autor, editorial, ISBN, etc.
En un listado de libros, cada ítem puede tener también la microdata del tipo Book, si es relevante para SEO.
No tiene sentido poner la microdata de una sucursal en cada página del sitio, solo la incluiría en la página de contacto, en el footer o en una sección específica de ubicación, donde tiene más sentido semántico usar itemtype="https://schema.org/LocalBusiness" o PostalAddress.

- Aplicamos microodata usando el vocabulario de Schema.org en el archivo order-list.php, home.php y book.php

- Cada tag <article> ahora declara itemscope itemtype="https://schema.org/Order" para representar un pedido.

- Usamos propiedades coom orderNumber, orderDate, deliveryMethod y customer.

- Encapsulamos la información del cliente dentro de un objeto Person, usando itemprop="customer" junto con name, email, y telephone.

- Mejoramos la semántica del HTML sin afectar la visualización ni la funcionalidda.
