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
        ['path' => '/', 'action' => 'PageController@index', 'method' => 'GET'],
        ['path' => '/books.json',   'action' => 'BooksController@indexJson', 'method' => 'GET'],
        ['path' => '/about-us', 'action' => 'PageController@aboutUs', 'method' => 'GET'],
        ['path' => '/login', 'action' => 'PageController@login', 'method' => 'GET'],
        ['path' => '/create-account', 'action' => 'PageController@createAccount', 'method' => 'GET'],
        ['path' => '/books', 'action' => 'BooksController@index', 'method' => 'GET'],
        ['path' => '/book', 'action' => 'BooksController@show', 'method' => 'GET'],
        ['path' => '/shopping-cart', 'action' => 'CartController@show', 'method' => 'GET'],
        ['path' => '/checkout-form', 'action' => 'CheckoutController@showForm', 'method' => 'GET'],
        ['path' => '/checkout-form', 'action' => 'CheckoutController@submit', 'method' => 'POST']
    ],


    'database' => [
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('DB_DBNAME'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => getenv('DB_CHARSET')
    ],

    // Email configurado en .env o sino uno por defecto, en este caso puse el mismo igual
    'checkout_email' => getenv('CHECKOUT_EMAIL') ?: 'ventas@pawprints.local'
];
