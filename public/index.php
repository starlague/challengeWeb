<?php 

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\UserController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/public', '', $path);
$path = $path === '' ? '/' : $path;

$data = ['title' => 'Blog', 'content' => ''];

//home
if ($path === '/') {
    $controller = new HomeController();
    $data = $controller->index();
//users list
} elseif ($path === '/users') {
    $controller = new UserController();
    $data = $controller->listUsers();
//registration
} elseif ($path === '/register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->createUser();
    } else {
        $controller = new UserController();
        $data = $controller->showRegister();
    }
//login
} elseif ($path === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->loginUser();
    } else {
        $controller = new UserController();
        $data = $controller->showLogin();
    }
//user profil
} elseif ($path === '/profil') {
    $controller = new UserController();
    $data = $controller->showUser();
}else {
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';