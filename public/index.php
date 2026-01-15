<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\CommentController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/public', '', $path);
$path = $path === '' ? '/' : $path;

$data = ['title' => 'Blog', 'content' => ''];

// ========================
// ROUTING
// ========================

// Accueil
if ($path === '/') {
    $controller = new HomeController();
    $data = $controller->index();

// Liste des utilisateurs
} elseif ($path === '/users') {
    $controller = new UserController();
    $data = $controller->listUsers();

// Inscription
} elseif ($path === '/register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->createUser();
    } else {
        $controller = new UserController();
        $data = $controller->showRegister();
    }

// Connexion
} elseif ($path === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new UserController();
        $controller->loginUser();
    } else {
        $controller = new UserController();
        $data = $controller->showLogin();
    }

// Profil utilisateur
} elseif ($path === '/profil') {
    $controller = new UserController();
    $data = $controller->showUser();

// AJAX : création de commentaire
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

// Page non trouvée
} else {
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

// ========================
// Récupération des données pour le layout
// ========================
$title = $data['title'];
$content = $data['content'];

require_once __DIR__ . '/../templates/layout.php';
