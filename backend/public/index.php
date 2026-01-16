<?php

declare(strict_types=1);

// Autoload Composer
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// CORS Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Initialisation Router
$router = new Router();

// Charger les routes depuis le fichier de configuration
try {
    require __DIR__ . '/../config/api-routes.php';
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Route loading error',
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
    exit;
}

// Dispatch
try {
    $router->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI']
    );
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Dispatch error',
        'message' => $e->getMessage()
    ]);
}

