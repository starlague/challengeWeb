<?php

namespace App\Models;

use App\Database;

class Post {

    public static function create($userId, $title, $content, $image = null) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO post (idUser, title, content, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $content, $image]);
    }

    public static function getAll() {
        $pdo = Database::getInstance();
        return $pdo->query("SELECT * FROM post ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }
}
