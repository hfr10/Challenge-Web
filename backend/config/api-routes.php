<?php

// ==================== ROOT ====================
$router->get('/', function() {
    echo json_encode(['message' => 'Welcome to the API', 'version' => '1.0', 'status' => 'running']);
});

$router->get('/test', function() {
    echo json_encode(['test' => 'success', 'timestamp' => date('Y-m-d H:i:s')]);
});

// ==================== PRODUCTS ====================
$router->get('/products', function() {
    try {
        $controller = new \App\Controllers\ProductController();
        $controller->index();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/products/{id}', function($id) {
    try {
        $controller = new \App\Controllers\ProductController();
        $controller->show((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/products', function() {
    try {
        $controller = new \App\Controllers\ProductController();
        $controller->create();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/products/{id}', function($id) {
    try {
        $controller = new \App\Controllers\ProductController();
        $controller->update((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/products/{id}', function($id) {
    try {
        $controller = new \App\Controllers\ProductController();
        $controller->delete((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

// ==================== AUTH ====================
$router->post('/auth/register', function() {
    try {
        $controller = new \App\Controllers\AuthController();
        $controller->register();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/auth/login', function() {
    try {
        $controller = new \App\Controllers\AuthController();
        $controller->login();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/auth/logout', function() {
    try {
        $controller = new \App\Controllers\AuthController();
        $controller->logout();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/auth/refresh', function() {
    try {
        $controller = new \App\Controllers\AuthController();
        $controller->refresh();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

// ==================== CART ====================
$router->get('/cart', function() {
    try {
        $controller = new \App\Controllers\CartController();
        $controller->index();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/cart/add', function() {
    try {
        $controller = new \App\Controllers\CartController();
        $controller->add();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/cart/items', function() {
    try {
        $controller = new \App\Controllers\CartController();
        $controller->items();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/cart/update/{id}', function($id) {
    try {
        $controller = new \App\Controllers\CartController();
        $controller->update((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/cart/remove/{id}', function($id) {
    try {
        $controller = new \App\Controllers\CartController();
        $controller->remove((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/cart/clear', function() {
    try {
        $controller = new \App\Controllers\CartController();
        $controller->clear();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

// ==================== ORDERS ====================
$router->post('/orders', function() {
    try {
        $controller = new \App\Controllers\OrderController();
        $controller->create();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/orders', function() {
    try {
        $controller = new \App\Controllers\OrderController();
        $controller->index();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/orders/{id}', function($id) {
    try {
        $controller = new \App\Controllers\OrderController();
        $controller->show((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/orders/{id}', function($id) {
    try {
        $controller = new \App\Controllers\OrderController();
        $controller->update((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/orders/{id}/status', function($id) {
    try {
        $controller = new \App\Controllers\OrderController();
        $controller->updateStatus((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/orders/{id}', function($id) {
    try {
        $controller = new \App\Controllers\OrderController();
        $controller->delete((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

// ==================== USERS ====================
$router->get('/users/{id}', function($id) {
    try {
        $controller = new \App\Controllers\UserController();
        $controller->show((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/users/{id}', function($id) {
    try {
        $controller = new \App\Controllers\UserController();
        $controller->update((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/users/{id}', function($id) {
    try {
        $controller = new \App\Controllers\UserController();
        $controller->delete((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/users/{id}/orders', function($id) {
    try {
        $controller = new \App\Controllers\UserController();
        $controller->getOrders((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

// ==================== ADMIN ====================
$router->get('/admin/dashboard', function() {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->getDashboardStats();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/admin/orders', function() {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->getAllOrders();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/admin/users', function() {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->getAllUsers();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->get('/admin/products', function() {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->getAllProducts();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/admin/users/{id}', function($id) {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->updateUser((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/admin/users/{id}', function($id) {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->deleteUser((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->post('/admin/products', function() {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->createProduct();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/admin/products/{id}', function($id) {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->updateProduct((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/admin/products/{id}', function($id) {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->deleteProduct((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->put('/admin/orders/{id}', function($id) {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->updateOrder((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});

$router->delete('/admin/orders/{id}', function($id) {
    try {
        $controller = new \App\Controllers\AdminController();
        $controller->deleteOrder((int)$id);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});
