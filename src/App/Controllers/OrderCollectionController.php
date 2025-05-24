<?php

namespace Paw\App\Controllers;

use Paw\Core\AbstractController;
use Paw\App\Models\OrderCollection;
use Paw\Core\Middelware\AuthMiddelware;
class OrderCollectionController extends AbstractController {
    public ?string $modelName = OrderCollection::class;
    private int $sizePage = 6;

    public function orderList(){
        AuthMiddelware::checkSessionTimeout();
        AuthMiddelware::checkSession();
        $orderCollectionModel = $this->getModel(OrderCollection::class);
        $ordersLists = $orderCollectionModel->getAll();
        require $this->viewsDir . 'order-list.php';
    }
}