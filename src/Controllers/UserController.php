<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
    public function listUsers() {
        $user = new User();
        $users = $user->getAllUsers();
        
        ob_start();
        require __DIR__ . '/../views/user.php/index.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Liste des utilisateurs',
            'content' => $content
        ];
    }

    public function showRegister() {
        ob_start();
        require __DIR__ . '/../views/user.php/register.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Inscription',
            'content' => $content
        ];
    }

    public function createUser() {
        try {
            //check the POST method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Méthode non autorisée');
            }

            //recover the data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $bio = $_POST['bio'];

            //create the user
            $user = new User();
            $user->setUsername(htmlspecialchars($username));
            $user->setEmail(htmlspecialchars($email));
            $user->setPassword($password);
            $user->setBio(htmlspecialchars($bio));

            //save the data
            $user->saveUser();

            header('Location: /users');
            exit;

        } catch (\Exception $e) {
            //display the message and redirect
            $_SESSION['error'] = $e->getMessage();
            header('Location: /register');
            exit;
        }
    }
}    
