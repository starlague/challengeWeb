<?php
namespace App\Controllers;

use App\Models\User;

class LoginController {

    public function showLogin() {
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
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Méthode non autorisée");
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = User::findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                throw new \Exception("Email ou mot de passe incorrect");
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'bio' => $user['bio'],
            ];

            header('Location: /');
            exit;
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /login');
            exit;
        }
    }
}
