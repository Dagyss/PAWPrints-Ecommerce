<?php
require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Paw\Core\Router;
use Paw\Core\Request;

// Cargamos configuración
$config = require __DIR__ . '/../src/Config/config.php';

define('DEBUG', $config['debug']);

// Logger
$log = new Logger($config['log']['name']);
$log->pushHandler(new StreamHandler($config['log']['path'], $config['log']['level']));

// Whoops (sólo en modo desarrollo)
if (DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}

$request = new Request;

// Cargamos rutas desde config
$router = new Router();
$router->setLogger($log);

foreach ($config['routes'] as $path => $controllerAction) {
    $router->loadRoutes($path, $controllerAction);
}
