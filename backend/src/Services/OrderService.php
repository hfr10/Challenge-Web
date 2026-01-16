<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderService
{
    private OrderRepository $orderRepo;
    private ProductRepository $productRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepository();
        $this->productRepo = new ProductRepository();
    }

    /**
     * Create a new order with items
     *
     * @param int $userId
     * @param array $items Array of items with product_id and quantity
     * @param string $shippingAddress
     * @return array|null Returns order data or null on failure
     */
    public function createOrder(int $userId, array $items, string $shippingAddress): ?array
    {
        // Validate and prepare items with pricing
        $preparedItems = [];
        $total = 0.0;

        foreach ($items as $item) {
            $product = $this->productRepo->getById($item['product_id']);

            if (!$product || $product['stock_quantity'] < $item['quantity']) {
                return null; // Product not found or insufficient stock
            }

            $subtotal = $product['price'] * $item['quantity'];
            $preparedItems[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $product['price'],
                'subtotal' => $subtotal
            ];
            $total += $subtotal;
        }

        // Create the order
        $orderId = $this->orderRepo->create($userId, $total, $shippingAddress, $preparedItems);

        if (!$orderId) {
            return null;
        }

        return $this->getOrderById($orderId);
    }

    /**
     * Get order by ID with all items
     *
     * @param int $id
     * @return array|null
     */
    public function getOrderById(int $id): ?array
    {
        return $this->orderRepo->findById($id);
    }

    /**
     * Get all orders for a specific user
     *
     * @param int $userId
     * @return array
     */
    public function getUserOrders(int $userId): array
    {
        return $this->orderRepo->findByUserId($userId);
    }

    /**
     * Update order status
     *
     * @param int $id
     * @param string $status (pending, processing, shipped, delivered, cancelled)
     * @return bool
     */
    public function updateOrderStatus(int $id, string $status): bool
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return false;
        }

        return $this->orderRepo->updateStatus($id, $status);
    }

    /**
     * Get all orders (admin)
     *
     * @return array
     */
    public function getAllOrders(): array
    {
        return $this->orderRepo->getAll();
    }
}
