<?php
require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Paw\Core\Router;  

$log = new Logger('mvc-app');
$log->pushHandler(new StreamHandler(__DIR__ . "/../logs/app.log", Logger::DEBUG)); 
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

#Para agregar paths nuevos
$router = new Router;
$router->loadRoutes("/", "PageController@index");
$router->loadRoutes("/about-us", "PageController@aboutUs");
$router->loadRoutes("/books", "PageController@books");
$router->loadRoutes("/login", "PageController@login");
$router->loadRoutes("/create-account", "PageController@createAccount");
$router->loadRoutes("not_found", "ErrorController@notFound");
$router->loadRoutes("internal_error", "ErrorController@internarError");