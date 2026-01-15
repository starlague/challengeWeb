<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
    public function listUsers() {
        $user = new User();
        $users = $user->getAllUsers();
        
        ob_start();
        require __DIR__ . '/../views/user/index.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Liste des utilisateurs',
            'content' => $content
        ];
    }

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
            //check the POST method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Méthode non autorisée');
            }

            //recover the data
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $bio = trim($_POST['bio']);

            //create the user
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setBio($bio);

            //save the data
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
            //display the message and redirect
            $_SESSION['error'] = $e->getMessage();
            header('Location: /register');
            exit;
        }
    }

    public function showLogin(){
        ob_start();
        require __DIR__ . '/../views/user/login.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Connexion',
            'content' => $content
        ];
    }

    public function loginUser() {
        try {
            //check the POST method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Méthode non autorisée');
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);

            if (!password_verify($password, $user['password'])) {
                throw new \Exception('Email ou mot de passe incorrect');
            }

            $_SESSION["user"] = [
                "id" => $user['id'],
                "username"=> $user['username'],
                "email"=> $user['email'],
                "bio"=> $user['bio'],
            ];

            header('Location: /');
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /login');
            exit;
        }
    }

    public function showUser(){
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir cette page.";
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        ob_start();
        require __DIR__ . '/../views/user/profil.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Connexion',
            'content' => $content,
            'user' => $user
        ];
    }

    public function showUpdate() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir cette page.";
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        ob_start();
        require __DIR__ . '/../views/user/update.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Connexion',
            'content' => $content,
            'user' => $user
        ];
    }

    public function updateProfil(){
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Méthode non autorisée");
            }

            if (!isset($_SESSION['user'])) {
                throw new \Exception("Utilisateur non connecté");
            }

            $id = (int) $_SESSION['user']['id'];

            $userModel = new User();
            $dbUser = $userModel->getUserById($id); 

            if (!$dbUser) {
                throw new \Exception("Utilisateur introuvable");
            }

            //old values
            $oldUsername = $dbUser['username'];
            $oldEmail    = $dbUser['email'];
            $oldBio      = $dbUser['bio'];
            $oldPassword = $dbUser['password'];

            //new values from the form
            $newUsername = $_POST['username'] ?? '';
            $newEmail    = $_POST['email'] ?? '';
            $newBio      = $_POST['bio'] ?? '';

            //if empty keep old values
            $username = $newUsername !== '' ? $newUsername : $oldUsername;
            $email    = $newEmail    !== '' ? $newEmail    : $oldEmail;
            $bio      = $newBio      !== '' ? $newBio      : $oldBio;

            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                $password = $oldPassword;
            }

            $user = new User();
            $user->setId($id);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setBio($bio);
            $user->setPassword($password);

            if (!$user->updateUser()) {
                throw new \Exception("Erreur lors de la mise à jour du profil");
            }

            //update session
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email']    = $email;
            $_SESSION['user']['bio']      = $bio;

            header('Location: /profil');
            exit;

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();

            if (!isset($_SESSION['user'])) {
                header('Location: /login');
            } else {
                header('Location: /profil/update');
            }
            exit;
        }
    }
}    
