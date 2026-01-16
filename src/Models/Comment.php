<?php
namespace App\Models;

use App\Database;
use PDO;

class Comment {

    public static function create($idPost, $idUser, $content) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO `comment` (idPost, idUser, content) VALUES (?, ?, ?)");
        $stmt->execute([$idPost, $idUser, $content]);
    }

    public static function getByPost($idPost) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT c.*, u.username
            FROM comment c
            JOIN users u ON c.idUser = u.id
            WHERE c.idPost = ?
            ORDER BY c.id ASC
        ");
        $stmt->execute([$idPost]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteByIdAndUser($idComment, $idUser) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM comment WHERE id = ? AND idUser = ?");
        $stmt->execute([$idComment, $idUser]);
    }
}
