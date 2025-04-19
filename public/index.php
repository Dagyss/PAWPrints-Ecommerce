<?php

require __DIR__ . "/../src/bootstrap.php";
use Paw\Core\Exceptions\RouteNotFoundException;


#Ejemplo de uso de errores
#throw new \Exception('ERROR');


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$log->info("Petición a: {$path}");



try{
    $router->direct($path);
    $log->info("Status Code: 200 - {$path}");
} catch(RouteNotFoundException $e){
    $router->direct('not_found');
    $log->info("Status Code: 404 - Route Not Found", ["Error" => $e] );
} catch(Exception $e){
    $router->direct("internar_error");
    $log->error("Status Code: 500 - Internal Server Error", ["Error" => $e]);
}

?>

