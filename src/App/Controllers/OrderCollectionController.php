<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\OrderCollection;
use Paw\Core\Middelware\AuthMiddelware;
class OrderCollectionController extends AbstractController {
    public ?string $modelName = OrderCollection::class;
    private int $porPagina = 3;

    public function orderList(){
        AuthMiddelware::checkSessionTimeout();
        AuthMiddelware::checkSession();
        if ($_SESSION['user']['role'] !== 'cliente'){
            $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($paginaActual - 1) * $this->porPagina;
            $orderCollectionModel = $this->getModel(OrderCollection::class);
            $ordersLists = $orderCollectionModel->getAll();
            
            $totalOrderLists = count($ordersLists);
            $totalPaginas = ceil($totalOrderLists / $this->porPagina);
            $ordersLists = array_slice($ordersLists, $offset, $this->porPagina);
            if ($paginaActual > $totalPaginas || $paginaActual < 1){
                header("HTTP/1.1 404 Not Found");
                require $this->viewsDir . 'errors/not-found.php';
                exit;
            }
            require $this->viewsDir . 'order-list.php';
        }else{
            header('HTTP/1.1 403 Forbidden');
            require $this->viewsDir . 'errors/403.php';
        }
    }
}