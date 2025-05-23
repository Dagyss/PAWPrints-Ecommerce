<?php
namespace Paw\App\Services;

use Paw\App\Models\BooksCollection;
use Paw\App\Models\Order;
use Paw\App\Models\OrderCollection;
use Paw\App\Models\OrderItemCollection;
use Paw\Core\Database\QueryBuilder;
use PDOException;

class OrderService
{
    private OrderCollection $orders;
    private OrderItemCollection $orderItems;
    private BooksCollection $books;

    public function __construct()
    {
        $qb = QueryBuilder::getInstance();
        $this->orders = new OrderCollection($qb);
        $this->orderItems = new OrderItemCollection($qb);
        $this->books = new BooksCollection($qb);
    }

    public function validateStock(array $cartItems): array
    {
        $errors = [];
        foreach ($cartItems as $ci) {
            $book = $this->books->getById((int)$ci['id']);
            $cant  = (int)$ci['cantidad'];

            if ($book->fields['stock'] < $cant) {
                $errors[$book->fields['id']] = sprintf(
                    "Solo hay %d unidad(es) de «%s» en stock, solicitaste %d.",
                    $book->stock,
                    $book->titulo,
                    $cant
                );
            }
        }
        return $errors;
    }

    public function createOrderWithItems(Order $order, array $items): bool
    {
        $conn = QueryBuilder::getInstance()->getConnection();
        try {
            $conn->beginTransaction();

            $newOrderId = $this->orders->createOrder($order);
            $order->setOrderId((int) $newOrderId);

            foreach ($items as $item) {
                $book = $this->books->getById($item->fields['book_id']);
                $qty  = $item->fields['cantidad'];

                $item->setOrderId($newOrderId);
                $this->orderItems->createItem($item);

                $book->setStock($book->stock - $qty);
                $this->books->updateBook($book);
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
