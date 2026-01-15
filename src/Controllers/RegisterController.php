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
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Méthode non autorisée");
            }

            $username = htmlspecialchars($_POST['username']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $bio = htmlspecialchars($_POST['bio']);

            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setBio($bio);

            $user->saveUser();

            $_SESSION['user'] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'bio' => $user->getBio(),
            ];

            header('Location: /');
            exit;

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /register');
            exit;
        }
    }
}
