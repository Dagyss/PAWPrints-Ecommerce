<?php

namespace Paw\Core;

class AbstractController{
    public string $viewsDir = "";
    public array $menu_nav = [];

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
    }
}

?>