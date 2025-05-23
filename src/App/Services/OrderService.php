<?php
namespace Paw\App\Services;

use Paw\App\Models\Order;
use Paw\App\Models\OrderCollection;
use Paw\App\Models\OrderItemCollection;
use Paw\Core\Database\QueryBuilder;
use PDOException;

class OrderService
{
    private OrderCollection $orders;
    private OrderItemCollection $orderItems;

    public function __construct()
    {
        $qb = QueryBuilder::getInstance();
        $this->orders     = new OrderCollection($qb);
        $this->orderItems = new OrderItemCollection($qb);
    }

    public function createOrderWithItems(Order $order, array $items): bool
    {
        $conn = QueryBuilder::getInstance()->getConnection();
        try {
            $conn->beginTransaction();

            $newOrderId = $this->orders->createOrder($order);
            $order->setOrderId((int) $newOrderId);

            foreach ($items as $item) {
                $item->setOrderId($newOrderId);
                $this->orderItems->createItem($item);
            }

            $conn->commit();
            return true;

        } catch (PDOException $e) {
            $conn->rollBack();
            throw $e;
        } catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }
}