<?php
namespace App\Controllers;

use App\Database;

class PostController {

    public function listPosts() {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("
            SELECT p.title, p.content, u.username
            FROM post p
            JOIN users u ON p.idUser = u.id
            ORDER BY p.id DESC
        ");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createPost($idUser, $title, $content) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            INSERT INTO post (idUser, title, content)
            VALUES (:idUser, :title, :content)
        ");
        $stmt->execute([
            ':idUser' => $idUser,
            ':title' => $title,
            ':content' => $content
        ]);
    }
}
