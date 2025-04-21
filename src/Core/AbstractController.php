<?php

namespace Paw\Core;

use Paw\Core\AbstractModel;
use Paw\Core\Database\QueryBuilder;

class AbstractController{
    public string $viewsDir = "";
    public array $menu_nav = [];
    public ?string $modelName = null;

    public function __construct(){
        global $connection, $log;
        $this->viewsDir = __DIR__ . "/../App/views/";
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

        /* para conectar a la base de datos
        if(!is_null($this->modelName)){
            $qb = new QueryBuilder($connection, $log);
            $model = new $this->modelName;
            $model->setQueryBuilder($qb);
            $this->setModel($model);
        }*/
    }

    /*
    public function setModel(AbstractModel $model){
        $this->model = $model;
    }
    */

}

?>