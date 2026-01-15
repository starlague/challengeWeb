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
        $stmt = $pdo->query("
            SELECT p.*, u.username 
            FROM post p
            JOIN users u ON p.idUser = u.id
            ORDER BY p.id DESC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
