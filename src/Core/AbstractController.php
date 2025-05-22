<?php

namespace Paw\Core;

use Paw\Core\ModelFactory;
use Monolog\Logger;

class AbstractController{
    public string $viewsDir = "";
    public array $menu_nav = [];
    public ?string $modelName = null;
    public ?object $model = null;
    protected ModelFactory $modelFactory;
    protected Logger $logger;

    public function __construct(Logger $log){
        $this->logger = $log;
        $this->viewsDir = __DIR__ . "/../App/views/";
        $this->modelFactory = new ModelFactory($log);
        $this->menu_nav = [
            [
                "href" => "/books",
                "route_name" => "Libros"
            ],
            [
                "href" => "/News",
                "route_name" => "Novedades"
            ],
            [
                "href" => "/offer",
                "route_name" => "Ofertas"
            ],
            [
                "href" => "/best-seller",
                "route_name" => "Más vendidos"
            ],
            [
                "href" => "/branches",
                "route_name" => "Sucursales"
            ],
            [
                "href" => "/about-us",
                "route_name" => "Nosotros"
            ],
        ];

        if(!is_null($this->modelName)){
            $this->model = $this->modelFactory->make($this->modelName);
        }
    }

    public function getModel(string $modelClass): object
    {
        return $this->modelFactory->make($modelClass);
    }
}

?>