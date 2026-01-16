<?php

namespace App\Controllers;

class ProductController
{
    private static $products = [
        ['id' => 1, 'name' => 'Laptop Pro', 'description' => 'High-performance laptop', 'price' => 1299.99, 'category' => 'Electronics', 'stock' => 10, 'image' => '/images/laptop.jpg'],
        ['id' => 2, 'name' => 'Wireless Mouse', 'description' => 'Ergonomic wireless mouse', 'price' => 29.99, 'category' => 'Accessories', 'stock' => 50, 'image' => '/images/mouse.jpg'],
        ['id' => 3, 'name' => 'Mechanical Keyboard', 'description' => 'RGB mechanical keyboard', 'price' => 129.99, 'category' => 'Accessories', 'stock' => 30, 'image' => '/images/keyboard.jpg'],
        ['id' => 4, 'name' => 'USB-C Cable', 'description' => '2m USB-C charging cable', 'price' => 9.99, 'category' => 'Cables', 'stock' => 100, 'image' => '/images/cable.jpg'],
        ['id' => 5, 'name' => 'Monitor 4K', 'description' => '27 inch 4K monitor', 'price' => 499.99, 'category' => 'Electronics', 'stock' => 15, 'image' => '/images/monitor.jpg'],
        ['id' => 6, 'name' => 'Webcam HD', 'description' => '1080p HD webcam', 'price' => 79.99, 'category' => 'Accessories', 'stock' => 25, 'image' => '/images/webcam.jpg'],
    ];

    public function index(): void
    {
        header('Content-Type: application/json');
        try {
            echo json_encode([
                'success' => true,
                'products' => self::$products
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function show($id): void
    {
        header('Content-Type: application/json');
        try {
            $product = null;
            foreach (self::$products as $p) {
                if ($p['id'] == $id) {
                    $product = $p;
                    break;
                }
            }

            if (!$product) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Product not found']);
                return;
            }

            echo json_encode(['success' => true, 'product' => $product]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function create(): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Product created']);
    }

    public function update($id): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Product updated']);
    }

    public function delete($id): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Product deleted']);
    }
}
            ]);
        }
    }

    public function show(int $id): void
    {
        header('Content-Type: application/json');
        try {
            $product = $this->repo->getById($id);

            if (!$product) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Produit introuvable'
                ]);
                return;
            }

            echo json_encode([
                'success' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
