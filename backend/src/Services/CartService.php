<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class CartService
{
    private ProductRepository $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
        $this->initSession();
    }

    /**
     * Initialize session if not started
     */
    private function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Add item to cart
     *
     * @param int $productId
     * @param int $quantity
     * @return array|null Returns cart or null if product not found/insufficient stock
     */
    public function addToCart(int $productId, int $quantity = 1): ?array
    {
        $product = $this->productRepo->getById($productId);

        if (!$product) {
            return null; // Product not found
        }

        // Check if product already in cart
        if (isset($_SESSION['cart'][$productId])) {
            $newQuantity = $_SESSION['cart'][$productId]['quantity'] + $quantity;

            // Check stock availability
            if ($newQuantity > $product['stock_quantity']) {
                return null; // Insufficient stock
            }

            $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
        } else {
            // Check stock availability
            if ($quantity > $product['stock_quantity']) {
                return null; // Insufficient stock
            }

            $_SESSION['cart'][$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'] ?? null
            ];
        }

        return $this->getCart();
    }

    /**
     * Remove item from cart
     *
     * @param int $productId
     * @return array Returns updated cart
     */
    public function removeFromCart(int $productId): array
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        return $this->getCart();
    }

    /**
     * Update item quantity in cart
     *
     * @param int $productId
     * @param int $quantity
     * @return array|null Returns cart or null if invalid
     */
    public function updateQuantity(int $productId, int $quantity): ?array
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($productId);
        }

        if (!isset($_SESSION['cart'][$productId])) {
            return null; // Item not in cart
        }

        $product = $this->productRepo->getById($productId);

        if (!$product || $quantity > $product['stock_quantity']) {
            return null; // Product not found or insufficient stock
        }

        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        return $this->getCart();
    }

    /**
     * Get current cart with calculated totals
     *
     * @return array
     */
    public function getCart(): array
    {
        $cart = $_SESSION['cart'] ?? [];
        $items = array_values($cart);
        $total = $this->calculateTotal();

        return [
            'items' => $items,
            'total' => $total,
            'item_count' => array_sum(array_column($items, 'quantity'))
        ];
    }

    /**
     * Clear entire cart
     *
     * @return array Returns empty cart
     */
    public function clearCart(): array
    {
        $_SESSION['cart'] = [];

        return $this->getCart();
    }

    /**
     * Calculate cart total
     *
     * @return float
     */
    public function calculateTotal(): float
    {
        $total = 0.0;

        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return round($total, 2);
    }

    /**
     * Get cart items formatted for order creation
     *
     * @return array
     */
    public function getCartItemsForOrder(): array
    {
        $items = [];

        foreach ($_SESSION['cart'] as $item) {
            $items[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ];
        }

        return $items;
    }
}
