<?php
namespace Paw\App\Controller;

class ErrorController{
    public string $viewsDir = "";
    public array $menu_nav = [];

    public function __construct(){
        $this->viewsDir = __DIR__ . "/../views/";
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

    public function notFound(){
        require $this->viewsDir . 'not-found.php';
    }
}
?>