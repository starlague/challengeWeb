<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\CommentController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\PostController;

// Start the session to manage user login and session data
session_start();

// Load Composer's autoloader to automatically include classes
require_once __DIR__ . '/../vendor/autoload.php';

// --- URL Path Parsing ---
// Get the path from the requested URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove '/public' from path to match routing correctly
$path = str_replace('/public', '', $path); // <-- corrected

// Default path to '/' if no path is provided
$path = $path === '' ? '/' : $path;

// Initialize default page data
$data = ['title' => 'Blog', 'content' => ''];

// --- ROUTES HANDLING ---

if ($path === '/') {
    // Home page route
    $controller = new HomeController();
    $data = $controller->index();

} elseif ($path === '/users') {
    // List all users route
    $controller = new UserController();
    $data = $controller->listUsers();

} elseif ($path === '/register') {
    // User registration route
    $controller = new RegisterController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process form submission to create a new user
        $controller->createUser();
    } else {
        // Display registration form
        $data = $controller->showRegister();
    }

} elseif ($path === '/login') {
    // User login route
    $controller = new LoginController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process login form submission
        $controller->loginUser();
    } else {
        // Display login form
        $data = $controller->showLogin();
    }

} elseif ($path === '/logout') {
    // Logout route
    session_destroy(); // End the session
    header('Location: /'); // Redirect to home
    exit;

} elseif ($path === '/profil') {
    // Display user profile page
    $controller = new UserController();
    $data = $controller->showUser();

} elseif ($path === '/profil/update') {
    // Update user profile route
    $controller = new UserController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process profile update form
        $controller->updateProfil();
    } else {
        // Display profile update form
        $data = $controller->showUpdate();
    }

} elseif ($path === '/ajax/comment' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX route for creating a comment
    if (!isset($_SESSION['user'])) {
        // Return 403 if user is not logged in
        http_response_code(403);
        echo json_encode(['error' => 'Non connecté']);
        exit;
    }

    $commentController = new CommentController();
    $idPost = $_POST['comment_post_id'] ?? null; // Get post ID
    $content = $_POST['comment_content'] ?? null; // Get comment content
    $idUser = $_SESSION['user']['id']; // Current logged-in user ID

    if (!$idPost || !$content) {
        // Return 400 if parameters are missing
        http_response_code(400);
        echo json_encode(['error' => 'Paramètres manquants']);
        exit;
    }

    // Create the comment using the controller
    $commentController->createComment($idPost, $idUser, $content);

    // Return the new comment data as JSON
    echo json_encode([
        'username' => $_SESSION['user']['username'],
        'content' => htmlspecialchars($content), // Prevent XSS
        'id' => time(), // Temporary ID, replace with real ID if available
        'isAuthor' => true
    ]);
    exit;

} elseif ($path === '/ajax/comment/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX route for deleting a comment
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Non connecté']);
        exit;
    }

    $commentId = $_POST['comment_id'] ?? null;
    $userId = $_SESSION['user']['id'];

    if (!$commentId) {
        http_response_code(400);
        echo json_encode(['error' => 'ID du commentaire manquant']);
        exit;
    }

    try {
        $commentController = new CommentController();
        $commentController->deleteComment($commentId, $userId);
        echo json_encode(['success' => true]);
    } catch (\Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;

} elseif ($path === '/post/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX route for deleting a post
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
    } catch (\Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;

} elseif ($path === '/ajax/like' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX route to like a post
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }
    $postController = new PostController();
    echo json_encode($postController->ajaxLike());
    exit;

} elseif ($path === '/ajax/unlike' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX route to unlike a post
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Non connecté']);
        exit;
    }
    $postController = new PostController();
    echo json_encode($postController->ajaxUnlike());
    exit;

} elseif ($path === '/post') {
    // Display a single post page
    $controller = new PostController();
    $data = $controller->showPost();
} else {
    // 404 - Page not found
    $data = ['title' => 'Erreur', 'content' => '404 - Page non trouvée'];
}

// --- PAGE RENDERING ---
// Extract data for layout
$title = $data['title'];
$content = $data['content'];

// Include main layout template
require_once __DIR__ . '/../templates/layout.php';
