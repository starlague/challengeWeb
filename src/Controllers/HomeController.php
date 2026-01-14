<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController {

    public function index() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $image = null;

            if (!empty($_FILES['image']['name'])) {

                $image = time() . '_' . basename($_FILES['image']['name']);

                $uploadDir = __DIR__ . '/../../public/assets/uploads/';
                $destination = $uploadDir . $image;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    die("Erreur lors de l'upload de l'image !");
                }
            }

            Post::create(
                1,
                $_POST['title'],
                $_POST['content'],
                $image
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
