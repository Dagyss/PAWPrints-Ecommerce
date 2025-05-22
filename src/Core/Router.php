<?php

namespace Paw\Core;

use Exception;
use Paw\Core\Exceptions\RouteNotFoundException;
use Paw\Core\Request;
use Paw\Core\Traits\Loggeable;
use ReflectionMethod;

class Router {

    use Loggeable;
    public array $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => []
    ];

    public string $notFound = "not_found";
    public string $internalError = "internal_error";

    public function __construct()
    {
        $this->get($this->notFound, 'ErrorController@notFound');
        $this->get($this->internalError, 'ErrorController@internalError');
    }

    public function loadRoutes($path, $action, $method = "GET")
    {
        $this->routes[$method][$path] = $action;
    }

    public function get($path, $action)
    {
        $this->routes["GET"][$path] = $action;
    }

    public function post($path, $action)
    {
        $this->routes["POST"][$path] = $action;
    }

    public function put($path, $action)
    {
        $this->routes["PUT"][$path] = $action;
    }

    public function delete($path, $action)
    {
        $this->routes["DELETE"][$path] = $action;
    }

    public function exists($path, $method)
    {
        return array_key_exists($path, $this->routes[$method]);
    }

    public function getController($path, $http_method)
    {
        if (!array_key_exists($path, $this->routes[$http_method])) {
            throw new RouteNotFoundException("No existe ruta para esta Path y método HTTP");
        }
        return explode("@", $this->routes[$http_method][$path]);
    }

    public function call(string $controller, string $method, Request $request)
    {
        $controller_name = "Paw\\App\\Controllers\\{$controller}";
        $objController   = new $controller_name($this->logger);

        $this->logger->info("Llamando al controlador: {$controller} y método: {$method}");

        // Usamos reflection para ver cuántos parámetros espera el método
        $refMethod = new ReflectionMethod($objController, $method);
        $numParams = $refMethod->getNumberOfParameters();

        if ($numParams === 1) {
            // Si pide 1, le pasamos el Request
            return $objController->$method($request);
        }

        // Si no pide (o pide defaultables), lo llamamos sin args
        return $objController->$method();
    }

    public function direct(Request $request)
    {
        $this->logger->info("Ruta: {$request->uri()} y método HTTP: {$request->method()}");

        try {
            $route = $request->route();
            $path  = "/" . $route['uri'];
            $http_method = $route['method'];
            list($controller, $method) = $this->getController($path, $http_method);
        } catch (RouteNotFoundException $e) {
            $this->logger->error("Ruta no encontrada: " . $e->getMessage());
            list($controller, $method) = $this->getController($this->notFound, "GET");
        } catch (Exception $e) {
            $this->logger->error("Error: {$e->getMessage()}");
            list($controller, $method) = $this->getController($this->internalError, "GET");
        } finally {
            // Ahora le pasamos el $request en la llamada
            $this->call($controller, $method, $request);
        }
    }
}