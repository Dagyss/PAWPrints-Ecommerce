# TP3 - programación backend 1

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
│   ├── Core/
│   │   ├── Exceptions/
│   │   ├── Router.php
│   └── bootstrap.php
├── storage/
├── .env
└── composer.json
```

## Tecnologías y Herramientas

- PHP >= 7.4.3
- Composer para gestión de dependencias
- Sistema de logs ubicado en `/Logs/logs.app`

## Instrucciones de uso

1. Clonar el repositorio

```bash
git clone https://github.com/tu_usuario/tp3-pawprint.git cd tp3-pawprint
```

2. Instalar dependencias

```bash
composer update
```

3. Levantar el entorno de desarrollo

```bash
composer start
```

Esto iniciará un servidor PHP local en `http://localhost:9999`, sirviendo desde el directorio `public/`.

## Recursos del proyecto

- Trello del Proyecto: https://trello.com/b/LiHe9WLz/tp3-3era-entrega
- Drive del Proyecto TP3: https://drive.google.com/drive/folders/1-klkiw0SnbFlU5Uoi3_pyPiZa_urC-zp
