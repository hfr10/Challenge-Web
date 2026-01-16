<?php

namespace App\Controllers;

class AdminController
{
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function getDashboardStats(): void
    {
        echo json_encode(['success' => true, 'stats' => ['users' => 100, 'orders' => 500, 'revenue' => 50000]]);
    }

    public function getAllOrders(): void
    {
        echo json_encode(['success' => true, 'orders' => []]);
    }

    public function getAllUsers(): void
    {
        echo json_encode(['success' => true, 'users' => []]);
    }

    public function getAllProducts(): void
    {
        echo json_encode(['success' => true, 'products' => []]);
    }

    public function updateUser($id): void
    {
        echo json_encode(['success' => true, 'message' => 'User updated']);
    }

    public function deleteUser($id): void
    {
        echo json_encode(['success' => true, 'message' => 'User deleted']);
    }

    public function createProduct(): void
    {
        echo json_encode(['success' => true, 'message' => 'Product created']);
    }

    public function updateProduct($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Product updated']);
    }

    public function deleteProduct($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Product deleted']);
    }

    public function updateOrder($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Order updated']);
    }

    public function deleteOrder($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Order deleted']);
    }
}
    {
        if (!isset($data['admin_id'])) {
            return false;
        }

        $admin = $this->userRepo->findById((int)$data['admin_id']);

        return $admin && $admin['role'] === 'admin';
    }

    /**
     * Get all orders (admin only)
     *
     * @return void
     */
    public function getAllOrders(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Basic admin check
        if (!$this->isAdmin($data ?? [])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied. Admin privileges required.']);
            return;
        }

        $orders = $this->orderService->getAllOrders();

        echo json_encode([
            'orders' => $orders,
            'total' => count($orders)
        ]);
    }

    /**
     * Get all users (admin only)
     *
     * @return void
     */
    public function getAllUsers(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Basic admin check
        if (!$this->isAdmin($data ?? [])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied. Admin privileges required.']);
            return;
        }

        $users = $this->userRepo->getAll();

        echo json_encode([
            'users' => $users,
            'total' => count($users)
        ]);
    }

    /**
     * Delete a user (admin only)
     *
     * @param int $id
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Basic admin check
        if (!$this->isAdmin($data ?? [])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied. Admin privileges required.']);
            return;
        }

        // Check if user exists
        $user = $this->userRepo->findById($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        // Prevent deletion of admin accounts
        if ($user['role'] === 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Cannot delete admin accounts']);
            return;
        }

        // Prevent self-deletion
        if (isset($data['admin_id']) && (int)$data['admin_id'] === $id) {
            http_response_code(403);
            echo json_encode(['error' => 'Cannot delete your own account']);
            return;
        }

        // Perform deletion
        $success = $this->userRepo->delete($id);

        if (!$success) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete user']);
            return;
        }

        echo json_encode(['message' => 'User deleted successfully']);
    }

    /**
     * Update a product (admin only)
     *
     * @param int $id
     * @return void
     */
    public function updateProduct(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Basic admin check
        if (!$this->isAdmin($data ?? [])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied. Admin privileges required.']);
            return;
        }

        // Check if product exists
        $product = $this->productRepo->getById($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
            return;
        }

        // Remove admin_id from update data
        unset($data['admin_id']);

        if (empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'No update data provided']);
            return;
        }

        // Validate price if provided
        if (isset($data['price']) && $data['price'] < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Price cannot be negative']);
            return;
        }

        // Validate stock if provided
        if (isset($data['stock_quantity']) && $data['stock_quantity'] < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Stock quantity cannot be negative']);
            return;
        }

        // Perform update
        $success = $this->productRepo->update($id, $data);

        if (!$success) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update product']);
            return;
        }

        // Return updated product
        $updatedProduct = $this->productRepo->getById($id);

        echo json_encode([
            'message' => 'Product updated successfully',
            'product' => $updatedProduct
        ]);
    }

    /**
     * Get dashboard statistics (admin only)
     *
     * @return void
     */
    public function getDashboardStats(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Basic admin check
        if (!$this->isAdmin($data ?? [])) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied. Admin privileges required.']);
            return;
        }

        $orders = $this->orderService->getAllOrders();
        $users = $this->userRepo->getAll();

        $totalRevenue = array_reduce($orders, function ($sum, $order) {
            return $sum + ($order['total'] ?? 0);
        }, 0);

        $pendingOrders = array_filter($orders, function ($order) {
            return $order['status'] === 'pending';
        });

        echo json_encode([
            'total_orders' => count($orders),
            'total_users' => count($users),
            'total_revenue' => round($totalRevenue, 2),
            'pending_orders' => count($pendingOrders)
        ]);
    }
}
