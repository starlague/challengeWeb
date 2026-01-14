<?php

namespace App\Models;

use App\Database;
use PDO;

class Post {

    public static function create($idUser, $title, $content) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare(
            "INSERT INTO post (idUser, title, content) VALUES (?, ?, ?)"
        );
        $stmt->execute([$idUser, $title, $content]);
    }

    public static function getAll() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query(
            "SELECT p.title, p.content, u.username
             FROM post p
             JOIN users u ON p.idUser = u.id
             ORDER BY p.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
