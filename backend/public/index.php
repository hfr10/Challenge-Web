<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$routes = require __DIR__ . '/../config/routes.php';

$router = new Router($routes);
$router->dispatch();
