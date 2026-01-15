<?php
namespace App\Controllers;

use App\Models\User;

class RegisterController {

    public function showRegister() {
        ob_start();
        require __DIR__ . '/../views/user/register.php';
        $content = ob_get_clean();

        return [
            'title' => 'Inscription',
            'content' => $content
        ];
    }

public function createUser() {
        try {
            // Check the POST method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Méthode non autorisée');
            }

            // Recover the data
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $bio = trim($_POST['bio']);

            // Create the user
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setBio($bio);

            // Save the data
            $user->saveUser();

            $_SESSION["user"] = [
                "id" => $user->getId(),
                "username"=> $user->getUsername(),
                "email"=> $user->getEmail(),
                "bio"=> $user->getBio(),
            ];

            header('Location: /users');
            exit;

        } catch (\Exception $e) {
            // Display the message and redirect
            $_SESSION['error'] = $e->getMessage();
            header('Location: /register');
            exit;
        }
    }
}
