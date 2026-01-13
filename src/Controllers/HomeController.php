<?php

namespace App\Controllers;

class HomeController {
    public function index()
    {
        return [
            'title' => 'Accueil',
            'content' => 'Bienvenue sur mon blog!'
        ];
    }
}