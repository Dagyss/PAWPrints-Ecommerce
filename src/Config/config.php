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
        ['path' => '/', 'action' => 'HomeController@index', 'method' => 'GET'],
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
        'DB_ADAPTER' => 'mysql',
        'DB_HOSTNAME' => getenv('DB_HOST') ?: '127.0.0.1',
        'DB_DATABASE' => getenv('DB_NAME'),
        'DB_USERNAME' => getenv('DB_USER'),
        'DB_PASSWORD' => getenv('DB_PASSWORD'),
        'DB_PORT' => getenv('DB_PORT') ?: '3306',
        'DB_CHARSET' => getenv('DB_CHARSET') ?: 'utf8mb4'
    ],

    // Email configurado en .env o sino uno por defecto, en este caso puse el mismo igual
    'checkout_email' => getenv('CHECKOUT_EMAIL') ?: 'ventas@pawprints.local'
];
