<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\CommentController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\PostController;

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

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
    $controller = new RegisterController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->createUser();
    } else {
        $data = $controller->showRegister();
    }

} elseif ($path === '/login') {
    $controller = new LoginController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->loginUser();
    } else {
        $data = $controller->showLogin();
    }

} elseif ($path === '/logout') {
    session_destroy();
    header('Location: /');
    exit;

} elseif ($path === '/profil') {
    $controller = new UserController();
    $data = $controller->showUser();

} elseif ($path === '/profil/update') {
    $controller = new UserController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->updateProfil();
    } else {
        $data = $controller->showUpdate();
    }

} elseif ($path === '/ajax/comment' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Non connecté']);
        exit;
    }

    $commentController = new CommentController();
    $idPost = $_POST['comment_post_id'] ?? null;
    $content = $_POST['comment_content'] ?? null;
    $idUser = $_SESSION['user']['id'];

    if (!$idPost || !$content) {
        http_response_code(400);
        echo json_encode(['error' => 'Paramètres manquants']);
        exit;
    }

    $commentController->createComment($idPost, $idUser, $content);

    echo json_encode([
        'username' => $_SESSION['user']['username'],
        'content' => htmlspecialchars($content)
    ]);
    exit;

} elseif ($path === '/post/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Non connecté']);
        exit;
    }

    $postId = $_POST['post_id'] ?? null;
    $userId = $_SESSION['user']['id'];

    if (!$postId) {
        http_response_code(400);
        echo json_encode(['error' => 'ID du post manquant']);
        exit;
    }

    try {
        $postController = new PostController();
        $postController->deletePost($postId, $userId);

        echo json_encode(['success' => true]);
        exit;
    } catch (\Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }

} else {
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';
