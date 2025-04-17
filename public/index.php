<?php
require __DIR__ . '/../vendor/autoload.php';

use Paw\App\Controller\PageController;
use Paw\App\Controller\ErrorController;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

#Ejemplo de uso de errores
#throw new \Exception('ERROR');

$route = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$controller = new PageController;

switch ($route) {
    case '/':
        $controller->index();
        break;

    case '/books':
        $controller->books();
        break;

    case '/news':
        require __DIR__ . '/../src/Views/books.php';
        break;

    case '/offer':
        require __DIR__ . '/../src/Views/books.php';
        break;

    case '/best-seller':
        require __DIR__ . '/../src/Views/books.php';
        break;

    case '/branches':
        require __DIR__ . '/../src/Views/branches.php';
        break;

    case '/about-us':
        $controller->aboutUs();
        break;
    
    case '/login':
        $controller->login();
        break;

    case '/create-account':
        $controller->createAccount();
        break;

    default:
        $controller = new ErrorController;
        $controller->notFound();
        break;
}
?>

