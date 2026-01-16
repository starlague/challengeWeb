<?php
namespace App\Controllers;

use App\Models\User;

class LoginController {

    /**
     * Display the login page.
     *
     * Uses output buffering to capture the HTML content from the login view.
     *
     * @return array Returns an array containing the page title and content HTML
     */
    public function showLogin() {
        ob_start(); // Start output buffering
        require __DIR__ . '/../views/user/login.php'; // Include login view
        $content = ob_get_clean(); // Capture the output into $content

        return [
            'title' => 'Connexion', // Page title
            'content' => $content // Rendered HTML content
        ];
    }

    /**
     * Handle user login form submission.
     *
     * Validates email and password, starts user session if successful.
     * Redirects back to login page if there is an error.
     *
     * @return void
     */
    public function loginUser() {
        try {
            // Ensure the request method is POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Méthode non autorisée'); // Method not allowed
            }

            $email = $_POST['email']; // Get email from form
            $password = $_POST['password']; // Get password from form

            // Retrieve user from database by email
            $user = User::findByEmail($email);

            // Verify password against hashed password in database
            if (!password_verify($password, $user['password'])) {
                throw new \Exception('Email ou mot de passe incorrect'); // Invalid credentials
            }

            // Store user info in session
            $_SESSION["user"] = [
                "id" => $user['id'],
                "username"=> $user['username'],
                "email"=> $user['email'],
                "bio"=> $user['bio'],
            ];

            // Redirect to home page after successful login
            header('Location: /');
            exit;
        } catch (\Exception $e) {
            // Save error message in session and redirect back to login page
            $_SESSION['error'] = $e->getMessage();
            header('Location: /login');
            exit;
        }
    }
}
