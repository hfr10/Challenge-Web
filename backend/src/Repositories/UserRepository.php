<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(string $email, string $password): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (email, password) VALUES (:email, :password)"
        );
        $stmt->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
