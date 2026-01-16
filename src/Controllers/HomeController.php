<?php
namespace App\Controllers;

use App\Controllers\PostController;
use App\Controllers\CommentController;

class HomeController {

    /**
     * Display the home page with a list of posts including comments and likes.
     *
     * Handles post creation if a logged-in user submits the form.
     *
     * @return array Returns an array containing the page title, content HTML, and posts data
     */
    public function index() {
        $postController = new PostController();

        // Fetch all posts along with their comments and like counts
        $posts = $postController->listPostsWithCommentsAndLikes();

        // Handle new post creation if the request is POST and user is logged in
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $title = $_POST['title'] ?? ''; // Get post title from form
            $content = $_POST['content'] ?? ''; // Get post content from form
            $idUser = $_SESSION['user']['id']; // Current logged-in user ID

            if ($title && $content) {
                $imageName = null;

                // Handle image upload if an image is provided
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // Get file extension
                    $imageName = uniqid() . '.' . $ext; // Generate a unique filename
                    move_uploaded_file(
                        $_FILES['image']['tmp_name'], 
                        __DIR__ . '/../../public/assets/img/uploads/' . $imageName
                    ); // Move the uploaded file to the uploads folder
                }

                // Create a new post using the PostController
                $postController->createPost($idUser, $title, $content, $imageName);

                // Redirect to home page after successful post creation
                header('Location: /');
                exit;
            }
        }

        // Capture the view output
        ob_start();
        require __DIR__ . '/../views/home/index.php';
        $content = ob_get_clean();

        // Return data for rendering in the layout
        return [
            'title' => 'Accueil',
            'content' => $content,
            'posts' => $posts
        ];
    }
}
