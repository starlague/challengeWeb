<?php

namespace App\Controllers;

use App\Models\User;

class UserController {

    /**
     * Display the profile page of the currently logged-in user.
     *
     * Redirects to login page if the user is not logged in.
     *
     * @return array Returns an array containing the page title, HTML content, and user info
     */
    public function showUser(){
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir cette page.";
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        // Capture the profile view output
        ob_start();
        require __DIR__ . '/../views/user/profil.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Profil', // Page title
            'content' => $content, // Rendered HTML content
            'user' => $user // Current user info
        ];
    }

    /**
     * Display the user profile update form.
     *
     * Redirects to login page if the user is not logged in.
     *
     * @return array Returns an array containing the page title, HTML content, and user info
     */
    public function showUpdate() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez être connecté pour voir cette page.";
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];

        // Capture the update form view output
        ob_start();
        require __DIR__ . '/../views/user/update.php';
        $content = ob_get_clean();
        
        return [
            'title' => 'Modification du profil', // Page title
            'content' => $content, // Rendered HTML content
            'user' => $user // Current user info
        ];
    }

    /**
     * Handle the submission of the profile update form.
     *
     * Validates the input, updates user data, and updates session information.
     * Redirects to login page if the user is not logged in.
     *
     * @return void
     */
    public function updateProfil(){
        try {
            // Ensure the request method is POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("Méthode non autorisée");
            }

            // Ensure the user is logged in
            if (!isset($_SESSION['user'])) {
                throw new \Exception("Utilisateur non connecté");
            }

            $id = (int) $_SESSION['user']['id'];

            $userModel = new User();
            $dbUser = $userModel->getUserById($id); // Fetch the current user from database

            if (!$dbUser) {
                throw new \Exception("Utilisateur introuvable");
            }

            // Store old values from the database
            $oldUsername = $dbUser['username'];
            $oldEmail    = $dbUser['email'];
            $oldBio      = $dbUser['bio'];
            $oldPassword = $dbUser['password'];

            // Retrieve new values from the form
            $newUsername = $_POST['username'] ?? '';
            $newEmail    = $_POST['email'] ?? '';
            $newBio      = $_POST['bio'] ?? '';

            // Use old values if new ones are empty
            $username = $newUsername !== '' ? $newUsername : $oldUsername;
            $email    = $newEmail    !== '' ? $newEmail    : $oldEmail;
            $bio      = $newBio      !== '' ? $newBio      : $oldBio;

            // Handle password update
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password
            } else {
                $password = $oldPassword; // Keep the old password
            }

            // Update the user model
            $user = new User();
            $user->setId($id);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setBio($bio);
            $user->setPassword($password);

            if (!$user->updateUser()) {
                throw new \Exception("Erreur lors de la mise à jour du profil");
            }

            // Update session with new user info
            $_SESSION['user']['username'] = $username;
            $_SESSION['user']['email']    = $email;
            $_SESSION['user']['bio']      = $bio;

            // Redirect to profile page after successful update
            header('Location: /profil');
            exit;

        } catch (\Exception $e) {
            // Store error message in session
            $_SESSION['error'] = $e->getMessage();

            // Redirect based on login status
            if (!isset($_SESSION['user'])) {
                header('Location: /login');
            } else {
                header('Location: /profil/update');
            }
            exit;
        }
    }

    /**
     * Delete the currently logged-in user.
     *
     * Removes the user from the database, destroys the session, and redirects to home page.
     *
     * @return void
     */
    public function deleteUser() {
        $user = new User;

        $userId = $_SESSION['user']['id'];

        $user->delete($userId); // Delete user from database

        session_destroy(); // End session

        header('Location: /'); // Redirect to home page
        exit;
    }
}
