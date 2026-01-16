<?php

namespace App\Models;

use App\Database;
use PDO;

class PostLike {

    // Vérifie si un utilisateur a liké un post
    public static function isLikedByUser($postId, $userId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `likes` WHERE idPost = ? AND idUser = ?");
        $stmt->execute([$postId, $userId]);
        return $stmt->fetchColumn() > 0;
    }

    // Compte le nombre de likes d'un post
    public static function countLikes($postId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `likes` WHERE idPost = ?");
        $stmt->execute([$postId]);
        return (int)$stmt->fetchColumn();
    }

    // Ajouter un like
    public static function like($postId, $userId) {
        $pdo = Database::getInstance();
        if (!self::isLikedByUser($postId, $userId)) {
            $stmt = $pdo->prepare("INSERT INTO `likes` (number, idUser, idPost) VALUES (1, ?, ?)");
            $stmt->execute([$userId, $postId]);
        }
        return self::countLikes($postId);
    }

    // Supprimer un like
    public static function unlike($postId, $userId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM `likes` WHERE idPost = ? AND idUser = ?");
        $stmt->execute([$postId, $userId]);
        return self::countLikes($postId);
    }
}
