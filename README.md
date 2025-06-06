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

