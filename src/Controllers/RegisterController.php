<?php
namespace App\Controllers;

use App\Models\User;

class RegisterController {

    /**
     * Display the registration page.
     *
     * Uses output buffering to capture the HTML content from the registration view.
     *
     * @return array Returns an array containing the page title and content HTML
     */
    public function showRegister() {
        ob_start(); // Start output buffering
        require __DIR__ . '/../views/user/register.php'; // Include the registration view
        $content = ob_get_clean(); // Capture the output into $content

        return [
            'title' => 'Inscription', // Page title
            'content' => $content // Rendered HTML content
        ];
    }

    /**
     * Handle user registration form submission.
     *
     * Validates the input, creates a new user, and starts a session if successful.
     * Redirects back to the registration page if there is an error.
     *
     * @return void
     */
    public function createUser() {
        try {
            // Ensure the request method is POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Méthode non autorisée'); // Method not allowed
            }

            // Retrieve form data and trim whitespace
            $username = trim($_POST['username']); // Username from form
            $email = trim($_POST['email']); // Email from form
            $password = $_POST['password']; // Password from form
            $bio = trim($_POST['bio']); // User biography from form

            // Create a new User instance and set its properties
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setBio($bio);

            // Save the new user to the database
            $user->saveUser();

            // Store user info in session
            $_SESSION["user"] = [
                "id" => $user->getId(),
                "username"=> $user->getUsername(),
                "email"=> $user->getEmail(),
                "bio"=> $user->getBio(),
            ];

            // Redirect to the users list page after successful registration
            header('Location: /users');
            exit;

        } catch (\Exception $e) {
            // Save error message in session and redirect back to registration page
            $_SESSION['error'] = $e->getMessage();
            header('Location: /register');
            exit;
        }
    }
}
