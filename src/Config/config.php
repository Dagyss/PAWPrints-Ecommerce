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
        '/books' => 'PageController@books',
        '/login' => 'PageController@login',
        '/create-account' => 'PageController@createAccount',
        'not_found' => 'ErrorController@notFound',
        'internal_error' => 'ErrorController@internalError',
    ],
];
