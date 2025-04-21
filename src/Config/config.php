<?php

return [
    // Entorno de la aplicación
    'debug' => true,

    // Configuración de logs
    'log' => [
        'name' => 'mvc-app',
        'path' => __DIR__ . '/../../logs/app.log',
        'level' => Monolog\Logger::DEBUG
    ],

    // Configuración de rutas iniciales
    'routes' => [
        '/' => 'PageController@index',
        '/about-us' => 'PageController@aboutUs',
        '/login' => 'PageController@login',
        '/create-account' => 'PageController@createAccount',
        '/books' => 'BooksController@index'
    ],

    'database' => [
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('DB_DBNAME'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => getenv('DB_CHARSET')
    ]
];
