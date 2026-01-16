<?php

namespace App\Controllers;

class CartController
{
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function index(): void
    {
        echo json_encode(['success' => true, 'cart' => [], 'total' => 0]);
    }

    public function add(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode(['success' => true, 'message' => 'Item added to cart']);
    }

    public function items(): void
    {
        echo json_encode(['success' => true, 'items' => []]);
    }

    public function remove($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
    }

    public function update($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Cart updated']);
    }

    public function clear(): void
    {
        echo json_encode(['success' => true, 'message' => 'Cart cleared']);
    }
}
