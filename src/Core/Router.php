<?php

namespace Paw\Core;

use Exception;
use Paw\Core\Exceptions\RouteNotFoundException;
use Paw\Core\Request;
use Paw\Core\Traits\Loggeable;
use ReflectionMethod;
use Twig\Environment;

class Router {

    use Loggeable;

    /** @var array Las rutas organizadas por método HTTP */
    public array $routes = [
        "GET"    => [],
        "POST"   => [],
        "PUT"    => [],
        "DELETE" => []
    ];

    /** @var string Nombre de la ruta interna para 404 */
    public string $notFound      = "not_found";

    /** @var string Nombre de la ruta interna para error 500 */
    public string $internalError = "internal_error";

    /** @var Environment Instancia de Twig, inyectada desde bootstrap.php */
    protected Environment $twig;

    /**
     * Constructor: registra las rutas por defecto de error.
     */
    public function __construct()
    {
        $this->get($this->notFound, 'ErrorController@notFound');
        $this->get($this->internalError, 'ErrorController@internalError');
    }

    /**
     * Setter para inyectar el objeto Twig desde bootstrap.php
     * @param Environment $twig
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * Agrega una ruta genérica (usada por loadRoutes).
     */
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

    /**
     * Retorna [NombreControlador, NombreMétodo] para una ruta dada.
     * @param string $path
     * @param string $http_method
     * @throws RouteNotFoundException
     * @return array ['HomeController', 'index']
     */
    public function getController($path, $http_method)
    {
        if (!array_key_exists($path, $this->routes[$http_method])) {
            throw new RouteNotFoundException("No existe ruta para esta Path y método HTTP");
        }
        return explode("@", $this->routes[$http_method][$path]);
    }

    /**
     * Invoca el controlador y método correspondiente, inyectando Logger y Twig.
     *
     * @param string  $controller  Nombre de la clase de controlador (ej. 'HomeController')
     * @param string  $method      Nombre del método a invocar (ej. 'index')
     * @param Request $request     Instancia del Request actual
     * @return mixed
     */
    public function call(string $controller, string $method, Request $request)
    {
        // Formamos el FQCN del controlador
        $controller_name = "Paw\\App\\Controllers\\{$controller}";

        // Instanciamos el controlador pasándole el Logger (su __construct exige Logger)
        $objController = new $controller_name($this->logger);

        // **NUEVO**: inyectamos Twig en el controlador antes de llamar a su método
        if (isset($this->twig)) {
            $objController->setTwig($this->twig);
        }

        $this->logger->info("Llamando al controlador: {$controller} y método: {$method}");

        // Usamos reflection para detectar cuántos parámetros solicita el método
        $refMethod = new ReflectionMethod($objController, $method);
        $numParams = $refMethod->getNumberOfParameters();

        if ($numParams === 1) {
            // Si pide exactamente 1 parámetro, pasamos el Request
            return $objController->$method($request);
        }

        // Si no pide parámetros o todos tienen valores default, lo llamamos sin args
        return $objController->$method();
    }

    /**
     * Determina qué ruta corresponde al Request y la llama.
     *
     * @param Request $request
     * @return void
     */
    public function direct(Request $request)
    {
        $this->logger->info("Ruta: {$request->uri()} y método HTTP: {$request->method()}");

        try {
            $route       = $request->route();            // ej. ['uri' => 'books', 'method' => 'GET']
            $path        = "/" . $route['uri'];           // ej. "/books"
            $http_method = $route['method'];             // ej. "GET"

            list($controller, $method) = $this->getController($path, $http_method);
        } catch (RouteNotFoundException $e) {
            $this->logger->error("Ruta no encontrada: " . $e->getMessage());
            list($controller, $method) = $this->getController($this->notFound, "GET");
        } catch (Exception $e) {
            $this->logger->error("Error: {$e->getMessage()}");
            list($controller, $method) = $this->getController($this->internalError, "GET");
        } finally {
            // Aquí invocamos el controlador con Request
            $this->call($controller, $method, $request);
        }
    }
}