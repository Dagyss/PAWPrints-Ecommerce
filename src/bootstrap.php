<?php
require __DIR__ . '/../vendor/autoload.php';
#En producción, cambiar DEBUG A False
#Y en development si tenemos el Error 500 ver los logs en el archivo /logs/app.log
define('DEBUG', true);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Paw\Core\Router;  

$log = new Logger('mvc-app');
$log->pushHandler(new StreamHandler(__DIR__ . "/../logs/app.log", Logger::DEBUG));

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
} else {
    // Ocultamos todos los errores en producción
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}

#Para agregar paths nuevos
$router = new Router;
$router->loadRoutes("/", "PageController@index");
$router->loadRoutes("/about-us", "PageController@aboutUs");
$router->loadRoutes("/books", "PageController@books");
$router->loadRoutes("/login", "PageController@login");
$router->loadRoutes("/create-account", "PageController@createAccount");
$router->loadRoutes("not_found", "ErrorController@notFound");
$router->loadRoutes("internal_error", "ErrorController@internalError");