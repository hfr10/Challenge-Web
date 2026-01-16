<?php

namespace App\Controllers;

class UserController
{
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function show($id): void
    {
        echo json_encode(['success' => true, 'user' => ['id' => $id, 'email' => 'user@example.com', 'name' => 'User']]);
    }

    public function update($id): void
    {
        echo json_encode(['success' => true, 'message' => 'Profile updated']);
    }

    public function delete($id): void
    {
        echo json_encode(['success' => true, 'message' => 'User deleted']);
    }

    public function getOrders($id): void
    {
        echo json_encode(['success' => true, 'orders' => []]);
    }
}
            http_response_code(403);
            echo json_encode(['error' => 'Cannot delete admin accounts']);
            return;
        }

        // Perform deletion
        $success = $this->repo->delete($id);

        if (!$success) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete user']);
            return;
        }

        http_response_code(200);
        echo json_encode(['message' => 'User deleted successfully']);
    }
}
