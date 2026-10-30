<?php
// index.php - Front Router Sederhana
require_once __DIR__ . '/controllers/UserController.php';

$controller = new UserController();
$action = $_GET['action'] ?? 'index';

if ($action === 'create') {
    $controller->create();
} elseif ($action === 'edit') {
    $controller->edit();
} elseif ($action === 'delete') {
    $controller->delete();
} else {
    $controller->index();
}
