<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Core\Response;

class ProductController
{
    private ProductService $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function index(): void
    {
        Response::json($this->service->getAll());
    }

    public function show(int $id): void
    {
        $product = $this->service->getOne($id);

        if (!$product) {
            Response::json(['message' => 'Not found'], 404);
            return;
        }

        Response::json($product);
    }
}
