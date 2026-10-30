<?php
// index.php - Front Controller & Routing Gateway Enterprise MVC
session_start();

// Menentukan Controller dan Action dari Parameter Query String
$controllerName = isset($_GET['controller']) ? ucfirst(strtolower($_GET['controller'])) . 'Controller' : 'SupplierController';
$actionName     = isset($_GET['action']) ? strtolower($_GET['action']) : 'index';

$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    if (method_exists($controller, $actionName)) {
        // Eksekusi method aksi
        $controller->$actionName();
    } else {
        http_response_code(404);
        die('Aksi ' . htmlspecialchars($actionName) . ' tidak ditemukan pada ' . htmlspecialchars($controllerName) . '!');
    }
} else {
    http_response_code(404);
    die('Pengendali ' . htmlspecialchars($controllerName) . ' tidak ditemukan dalam arsitektur aplikasi!');
}
