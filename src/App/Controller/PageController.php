<?php
namespace Paw\App\Controller;

class PageController{
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

    public function index(){
        require $this->viewsDir . 'home.php';
    }

    public function aboutUs(){
        require $this->viewsDir . 'about-us.php';
    }

    public function books(){
        require $this->viewsDir . 'books.php';
    }

    public function login(){
        require $this->viewsDir . 'login.php';
    }
    public function createAccount(){
        require $this->viewsDir . 'create-account.php';
    }
    
    
}


?>