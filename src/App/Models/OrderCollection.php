<?php
namespace Paw\App\Models;

use Paw\App\Models\Order;
use Paw\Core\AbstractModel;

class OrderCollection extends AbstractModel
{
    public $table = "Orders";

    public function getAll(): array{
        $ordersData = $this->getQueryBuilder()->select($this->table);
        $ordersCollection = [];

        foreach ($ordersData as $orderData) {
            $order = new Order();
            $order->set($orderData);
            $ordersCollection[] = $order;
        }

        return $ordersCollection;
    }

    public function getById(int $id): ?Order{
        $orderData = $this->getQueryBuilder()->select($this->table, ["order_id" => $id]);
        $order = new Order();
        $order->set($orderData[0]);
        return $order;
    }

    public function createOrder(Order $order){
        return $this->getQueryBuilder()->insert($this->table, $order->fields);
    }

}