<?php
namespace Paw\App\Models;

use Paw\App\Models\OrderItem;
use Paw\Core\AbstractModel;

class OrderItemCollection extends AbstractModel
{
    public $table = "Order_Items";

    public function createItem(OrderItem $item): bool
    {
        return $this->getQueryBuilder()->insert($this->table, $item->fields);
    }

    public function createItems(array $items): bool
    {
        foreach ($items as $item) {
            $ok = $this->createItem($item);
            if (! $ok) {
                return false;
            }
        }
        return true;
    }


    public function getByOrderId(int $orderId): array
    {
        $rows = $this->getQueryBuilder()->select($this->table, ['order_id' => $orderId]);
        $collection = [];
        foreach ($rows as $row) {
            $item = new OrderItem();
            $item->set($row);
            $collection[] = $item;
        }
        return $collection;
    }
}