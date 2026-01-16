<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\PostLike;

class PostController {

    /**
     * List all posts with their comments and like information.
     *
     * For each post, also check if the current logged-in user has liked it.
     *
     * @return array Returns an array of posts with comments, like count, and user like status
     */
    public function listPostsWithCommentsAndLikes() {
        $posts = Post::getAllWithComments(); // Retrieve posts along with their comments

        foreach ($posts as &$post) {
            // Count the total likes for this post
            $post['likes'] = PostLike::countLikes($post['id']);
            
            // Determine if the current logged-in user has liked this post
            $post['likedByUser'] = isset($_SESSION['user'])
                ? PostLike::isLikedByUser($post['id'], $_SESSION['user']['id'])
                : false;
        }

        return $posts;
    }

    /**
     * Create a new post for a user.
     *
     * @param int $idUser ID of the user creating the post
     * @param string $title Title of the post
     * @param string $content Content of the post
     * @param string|null $imageName Optional image filename
     * @return mixed Returns the result of the Post::create method
     */
    public function createPost($idUser, $title, $content, $imageName = null) {
        return Post::create($idUser, $title, $content, $imageName);
    }

    /**
     * Delete a post if the user is authorized.
     *
     * @param int $postId ID of the post to delete
     * @param int $userId ID of the user attempting to delete the post
     * @return mixed Returns the result of the Post::delete method
     */
    public function deletePost($postId, $userId) {
        return Post::delete($postId, $userId);
    }

    /**
     * Handle AJAX request to like a post.
     *
     * @return array Returns success status and updated like count, or error if failed
     */
    public function ajaxLike() {
        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'error' => 'Non connecté']; // User not logged in
        }

        $postId = $_POST['post_id'] ?? null;
        if (!$postId) return ['success' => false, 'error' => 'ID du post manquant']; // Missing post ID

        $userId = $_SESSION['user']['id'];
        $likes = PostLike::like($postId, $userId); // Add like to the post

        return ['success' => true, 'likes' => $likes];
    }

    /**
     * Handle AJAX request to unlike a post.
     *
     * @return array Returns success status and updated like count, or error if failed
     */
    public function ajaxUnlike() {
        if (!isset($_SESSION['user'])) {
            return ['success' => false, 'error' => 'Non connecté']; // User not logged in
        }

        $postId = $_POST['post_id'] ?? null;
        if (!$postId) return ['success' => false, 'error' => 'ID du post manquant']; // Missing post ID

        $userId = $_SESSION['user']['id'];
        $likes = PostLike::unlike($postId, $userId); // Remove like from the post

        return ['success' => true, 'likes' => $likes];
    }

    /**
     * Display posts for the logged-in user.
     *
     * Redirects to login page if the user is not logged in.
     *
     * @return array Returns an array containing page title, HTML content, user info, and user posts
     */
    public function showPost(){
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir cette page.";
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        $postModel = new Post();
        $posts = $postModel->getUserPost($user['id']); // Fetch all posts for this user

        // Capture the view output
        ob_start();
        require __DIR__ . '/../views/post/index.php';
        $content = ob_get_clean();
        
        // Return data for rendering in the layout
        return [
            'title' => 'Post',
            'content' => $content,
            'user' => $user,
            'posts' => $posts
        ];
    }
}
