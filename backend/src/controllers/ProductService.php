<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $repo;

    public function __construct()
    {
        $this->repo = new ProductRepository();
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function getOne(int $id): ?array
    {
        return $this->repo->findById($id);
    }
}
