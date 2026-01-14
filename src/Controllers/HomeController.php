<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController {

    public function index() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Post::create(
                1, 
                $_POST['title'],
                $_POST['content']
            );
            header('Location: /');
            exit;
        }

        $posts = Post::getAll();

        ob_start();
        require __DIR__ . '/../views/home/index.php';
        $content = ob_get_clean();

        return [
            'title' => 'Accueil',
            'content' => $content
        ];
    }
}
