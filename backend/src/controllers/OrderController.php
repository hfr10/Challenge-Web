<?php

namespace App\Controllers;

class OrderController
{
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function create(): void
    {
        echo json_encode(['success' => true, 'message' => 'Order created', 'orderId' => 1]);
    }

    public function index(): void
    {
        echo json_encode(['success' => true, 'orders' => []]);
    }

    public function show($id): void
    {
        echo json_encode(['success' => true, 'order' => ['id' => $id, 'total' => 0, 'status' => 'pending']]);
    }

    public function update($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Order updated']);
    }

    public function updateStatus($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Order status updated']);
    }

    public function delete($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Order deleted']);
    }
}
