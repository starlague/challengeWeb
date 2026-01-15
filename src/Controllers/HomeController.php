<?php
namespace App\Controllers;

use App\Controllers\PostController;
use App\Controllers\CommentController;

class HomeController {

    public function index() {
        $postController = new PostController();
        $posts = $postController->listPosts();
        $commentController = new CommentController();

        // Gestion POST pour créer un post
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            if (isset($_POST['title']) && isset($_POST['content'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $idUser = $_SESSION['user']['id'];

                $imageName = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $imageName = uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/assets/uploads/' . $imageName);
                }

                $postController->createPost($idUser, $title, $content, $imageName);

                // Redirection simple vers l'accueil (PAS DE #post-ID)
                header('Location: /');
                exit;
            }
        }

        ob_start();
        require __DIR__ . '/../views/home/index.php';
        $content = ob_get_clean();

        return [
            'title' => 'Accueil',
            'content' => $content,
            'posts' => $posts
        ];
    }
}
