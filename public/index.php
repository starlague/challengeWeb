<?php 

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\UserController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/public', '', $path);
$path = $path === '' ? '/' : $path;

$data = ['title' => 'Blog', 'content' => ''];

if ($path === '/') {
    $controller = new HomeController();
    $data = $controller->index();
} elseif ($path === '/users') {
    $controller = new UserController();
    $data = $controller->listUsers();
} elseif ($path === '/register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->createUser();
    } else {
        $controller = new UserController();
        $data = $controller->showRegister();
    }
} elseif ($path === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->loginUser();
    } else {
        $controller = new UserController();
        $data = $controller->showLogin();
    }    
}else {
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';