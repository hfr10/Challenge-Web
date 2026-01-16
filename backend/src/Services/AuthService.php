<?php
namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function register(array $data): void
    {
        $this->repo->create($data['email'], $data['password'], $data['first_name'] ?? null, $data['last_name'] ?? null);
    }

    public function login(array $data): ?array
    {
        $user = $this->repo->findByEmail($data['email']);
        if (!$user || !password_verify($data['password'], $user['password_hash'])) return null;
        return $user;
    }
}
