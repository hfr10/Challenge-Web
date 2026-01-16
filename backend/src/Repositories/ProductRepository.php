<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class ProductRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT p.*, c.name AS category
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.is_active = true
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name AS category
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['name'])) {
            $fields[] = "name = :name";
            $params['name'] = $data['name'];
        }

        if (isset($data['description'])) {
            $fields[] = "description = :description";
            $params['description'] = $data['description'];
        }

        if (isset($data['price'])) {
            $fields[] = "price = :price";
            $params['price'] = $data['price'];
        }

        if (isset($data['stock_quantity'])) {
            $fields[] = "stock_quantity = :stock_quantity";
            $params['stock_quantity'] = $data['stock_quantity'];
        }

        if (isset($data['category_id'])) {
            $fields[] = "category_id = :category_id";
            $params['category_id'] = $data['category_id'];
        }

        if (isset($data['image_url'])) {
            $fields[] = "image_url = :image_url";
            $params['image_url'] = $data['image_url'];
        }

        if (isset($data['is_active'])) {
            $fields[] = "is_active = :is_active";
            $params['is_active'] = $data['is_active'];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }
}

