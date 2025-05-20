<?php
namespace App\Models;

use PDO;
use Core\Database;

class Cart
{
/*
    public static function getByUser(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT c.book_id, c.quantity, b.title, b.price, b.format, b.img
            FROM carts c
            JOIN books b ON b.id = c.book_id
            WHERE c.user_id = :uid
        ");
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function clearByUser(int $userId): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM carts WHERE user_id = :uid");
        $stmt->execute([':uid' => $userId]);
    }

*/
}