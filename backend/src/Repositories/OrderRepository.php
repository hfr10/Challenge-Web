<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class OrderRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(int $userId, float $total, string $shippingAddress, array $items): ?int
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, total, status, shipping_address)
                VALUES (:user_id, :total, 'pending', :shipping_address)
            ");
            $stmt->execute([
                'user_id' => $userId,
                'total' => $total,
                'shipping_address' => $shippingAddress
            ]);

            $orderId = (int)$this->db->lastInsertId();

            foreach ($items as $item) {
                $stmt = $this->db->prepare("
                    INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal)
                    VALUES (:order_id, :product_id, :quantity, :unit_price, :subtotal)
                ");
                $stmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return null;
        }
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM orders WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch();

        if (!$order) {
            return null;
        }

        $stmt = $this->db->prepare("
            SELECT oi.*, p.name as product_name
            FROM order_items oi
            LEFT JOIN products p ON p.id = oi.product_id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $id]);
        $order['items'] = $stmt->fetchAll();

        return $order;
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM orders
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT o.*, u.email as user_email
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET status = :status
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    }
}
