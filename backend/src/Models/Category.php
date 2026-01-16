<?php

namespace App\Models;

class Category
{
    public int $id;
    public string $name;
    public string $slug;
    public ?string $description;
    public string $created_at;
}
