<?php
namespace App\Models;

use App\Database;
use App\Models\Comment;
use PDO;

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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM post WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM post WHERE id = ?");
        $stmt->execute([$id]);
    }

    // --- NOUVEAU : récupérer tous les posts avec leurs commentaires ---
    public static function getAllWithComments() {
        $posts = self::getAll();
        foreach ($posts as &$post) {
            $post['comments'] = Comment::getByPost($post['id']);
        }
        return $posts;
    }
}
