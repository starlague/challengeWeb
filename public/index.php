<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\UserController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/public', '', $path);
$path = $path === '' ? '/' : $path;

$controller = new UserController();

if ($path === '/') {
    $controller = new HomeController();
    $data = $controller->index();
} elseif ($path === '/users') {
    $controller = new UserController();
    $data = $controller->listUsers();
} else {
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';