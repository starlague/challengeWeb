<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\PostLike;

class PostController {

    // Liste les posts avec commentaires et likes
    public function listPostsWithCommentsAndLikes() {
        $posts = Post::getAllWithComments(); // récupère posts + commentaires

        foreach ($posts as &$post) {
            $post['likes'] = PostLike::countLikes($post['id']);
            $post['likedByUser'] = isset($_SESSION['user'])
                ? PostLike::isLikedByUser($post['id'], $_SESSION['user']['id'])
                : false;
        }

        return $posts;
    }

    // Créer un post
    public function createPost($idUser, $title, $content, $imageName = null) {
        return Post::create($idUser, $title, $content, $imageName);
    }

    // Supprimer un post
    public function deletePost($postId, $userId) {
        return Post::delete($postId, $userId);
    }

    // AJAX Like
    public function ajaxLike() {
        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'error' => 'Non connecté'];
        }
        $postId = $_POST['post_id'] ?? null;
        if (!$postId) return ['success' => false, 'error' => 'ID du post manquant'];

        $userId = $_SESSION['user']['id'];
        $likes = PostLike::like($postId, $userId);

        return ['success' => true, 'likes' => $likes];
    }

    // AJAX Unlike
    public function ajaxUnlike() {
        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'error' => 'Non connecté'];
        }
        $postId = $_POST['post_id'] ?? null;
        if (!$postId) return ['success' => false, 'error' => 'ID du post manquant'];

        $userId = $_SESSION['user']['id'];
        $likes = PostLike::unlike($postId, $userId);

        return ['success' => true, 'likes' => $likes];
    }
}
