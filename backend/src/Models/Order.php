<?php

namespace App\Models;

class Order
{
    public int $id;
    public int $user_id;
    public float $total;
    public string $status;
    public ?string $shipping_address;
    public string $created_at;
    public array $items = [];
}
