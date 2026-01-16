<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Database;
use App\Repositories\ProductRepository;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-Type: application/json');

try {
    $db = Database::getInstance();
    echo json_encode(['status' => 'DB connected']);

    $repo = new ProductRepository();
    $products = $repo->getAll();

    echo json_encode([
        'status' => 'success',
        'products_count' => count($products),
        'products' => $products
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
