<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Core/helpers.php';
// Evitamos acceso por JS
ini_set('session.cookie_httponly', 1); 
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0); // Solo por HTTPS si aplica
ini_set('session.cookie_samesite', 'Lax');

session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Paw\Core\Router;
use Paw\Core\Request;
use Paw\Core\Database\Database;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

// Cargamos configuración
$config = require __DIR__ . '/../src/Config/config.php';

define('DEBUG', $config['debug']);

// Logger
$log = new Logger($config['log']['name']);
$log->pushHandler(new StreamHandler($config['log']['path'], $config['log']['level']));

// Inicializamos la base de datos
Database::initialize($config['database'], $log );

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

$loader = new FilesystemLoader(__DIR__ . '/../templates');

$twig = new Environment($loader, [
    'cache' => false,    
    'debug' => DEBUG,    
]);

if (DEBUG) {
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

$baseUrl = $config['base_url'] ?? '';
$twig->addGlobal('asset_path', rtrim($baseUrl, '/')); 

$pathFunction = new TwigFunction('path', function(string $route) use ($baseUrl) {
    // Asegurarse de que haya una sola barra intermedia:
    $prefix = rtrim($baseUrl, '/');
    // Por ejemplo, si $route = '/books', esto devuelve 'http://localhost:9999/books'
    return $prefix . $route;
});
$twig->addFunction($pathFunction);

// Cargamos rutas desde config
$router = new Router();
$router->setLogger($log);

$router->setTwig($twig);

foreach ($config['routes'] as $route) {
    $router->loadRoutes($route['path'], $route['action'], $route['method']);
}

