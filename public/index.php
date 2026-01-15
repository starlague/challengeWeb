<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\CommentController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/public', '', $path);
$path = $path === '' ? '/' : $path;

$data = ['title' => 'Blog', 'content' => ''];

// ========================
// ROUTING
// ========================

//home
if ($path === '/') {
    $controller = new HomeController();
    $data = $controller->index();

//users list
} elseif ($path === '/users') {
    $controller = new UserController();
    $data = $controller->listUsers();

//register
} elseif ($path === '/register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new RegisterController();
        $controller->createUser();
    } else {
        $controller = new RegisterController();
        $data = $controller->showRegister();
    }

//login
} elseif ($path === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new LoginController();
        $controller->loginUser();
    } else {
        $controller = new LoginController();
        $data = $controller->showLogin();
    }
// AJAX : creating comments
} elseif ($path === '/ajax/comment' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Non connecté']);
        exit;
    }

    $commentController = new CommentController();
    $idPost = $_POST['comment_post_id'];
    $content = $_POST['comment_content'];
    $idUser = $_SESSION['user']['id'];

    $commentController->createComment($idPost, $idUser, $content);

    echo json_encode([
        'username' => $_SESSION['user']['username'],
        'content' => htmlspecialchars($content)
    ]);
    exit;
//logout
} elseif ($path === '/logout') {
    session_start();
    session_destroy();
        
    header('Location: /');
    exit;
//user profil
} elseif ($path === '/profil') {
    $controller = new UserController();
    $data = $controller->showUser();
//update user profil
} elseif ($path === '/profil/update') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->updateProfil();
    } else {
        $controller = new UserController();
        $data = $controller->showUpdate();
    }
}else {
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';
