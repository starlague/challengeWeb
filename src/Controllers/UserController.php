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
}