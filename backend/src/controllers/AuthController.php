<?php
namespace App\Controllers;

class AuthController
{
    // Stockage temporaire (demo)
    private static $users = [
        ['id' => 1, 'email' => 'test@example.com', 'password' => '$2y$10$SlHT7FhGc5dJDnJLlr7q/.2xUlBZpJuVmfWhUvNaMMV1kBGrE3B3u', 'name' => 'Test User', 'role' => 'user']
    ];

    public function register(): void
    {
        header('Content-Type: application/json');
        
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Email et mot de passe requis']);
                return;
            }

            // Check if user exists
            foreach (self::$users as $user) {
                if ($user['email'] === $data['email']) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
                    return;
                }
            }

            $newUser = [
                'id' => count(self::$users) + 1,
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'name' => ($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''),
                'role' => 'user'
            ];

            self::$users[] = $newUser;
            $token = bin2hex(random_bytes(32));

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'token' => $token,
                'user' => ['id' => $newUser['id'], 'email' => $newUser['email'], 'name' => $newUser['name'], 'role' => $newUser['role']]
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function login(): void
    {
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Email et mot de passe requis']);
                return;
            }

            $user = null;
            foreach (self::$users as $u) {
                if ($u['email'] === $data['email']) {
                    $user = $u;
                    break;
                }
            }

            if (!$user || !password_verify($data['password'], $user['password'])) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
                return;
            }

            $token = bin2hex(random_bytes(32));

            echo json_encode([
                'success' => true,
                'token' => $token,
                'user' => ['id' => $user['id'], 'email' => $user['email'], 'name' => $user['name'], 'role' => $user['role']]
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function logout(): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    public function refresh(): void
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'token' => bin2hex(random_bytes(32))]);
    }
}
