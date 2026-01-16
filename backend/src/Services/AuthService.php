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

    public function register(string $email, string $password): void
    {
        $this->repo->create($email, $password);
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->repo->findByEmail($email);
        return $user && password_verify($password, $user['password']);
    }
}
