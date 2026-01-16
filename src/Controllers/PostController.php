<?php
namespace App\Controllers;

use App\Models\Post;
use App\Models\Comment;

class PostController {

    public function listPostsWithComments() {
        $posts = Post::getAll();
        foreach ($posts as &$post) {
            $post['comments'] = Comment::getByPost($post['id']);
        }
        return $posts;
    }

    public function createPost($idUser, $title, $content, $image = null) {
        Post::create($idUser, $title, $content, $image);
    }

    public function deletePost($postId, $userId) {
        $post = Post::getById($postId);

        if (!$post) throw new \Exception("Post introuvable");
        if ($post['idUser'] != $userId) throw new \Exception("Vous ne pouvez pas supprimer ce post");

        if (!empty($post['image']) && file_exists(__DIR__ . '/../../public/assets/img/uploads/' . $post['image'])) {
            unlink(__DIR__ . '/../../public/assets/img/uploads/' . $post['image']);
        }

        Post::delete($postId);
    }

    public function showPost(){
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir cette page.";
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        $postModel = new Post();
        $posts = $postModel->getUserPost($user['id']);

        ob_start();
        require __DIR__ . '/../views/post/index.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Post',
            'content' => $content,
            'user' => $user,
            'posts' => $posts
        ];
    }
}
