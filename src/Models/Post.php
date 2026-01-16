<?php
namespace App\Models;

use App\Database;
use App\Models\Comment;
use PDO;

class Post {

    /**
     * Create a new post in the database.
     *
     * @param int $userId ID of the user creating the post
     * @param string $title Title of the post
     * @param string $content Content of the post
     * @param string|null $image Optional image filename
     * @return void
     */
    public static function create($userId, $title, $content, $image = null) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("INSERT INTO post (idUser, title, content, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $content, $image]); // Execute insert query
    }

    /**
     * Retrieve all posts with their author username.
     *
     * Posts are sorted by ID in descending order (newest first).
     *
     * @return array Returns an array of posts with author info
     */
    public static function getAll() {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->query("
            SELECT p.*, u.username 
            FROM post p
            JOIN users u ON p.idUser = u.id
            ORDER BY p.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all posts as associative array
    }

    /**
     * Retrieve a single post by its ID.
     *
     * @param int $id ID of the post
     * @return array|null Returns the post as an associative array or null if not found
     */
    public static function getById($id) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT * FROM post WHERE id = ?");
        $stmt->execute([$id]); // Execute select query
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch single post
    }

    /**
     * Delete a post by its ID.
     *
     * @param int $id ID of the post to delete
     * @return void
     */
    public static function delete($id) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("DELETE FROM post WHERE id = ?");
        $stmt->execute([$id]); // Execute delete query
    }

    /**
     * Retrieve all posts with their associated comments.
     *
     * @return array Returns an array of posts, each including a 'comments' key with all related comments
     */
    public static function getAllWithComments() {
        $posts = self::getAll(); // Get all posts
        foreach ($posts as &$post) {
            $post['comments'] = Comment::getByPost($post['id']); // Attach comments for each post
        }
        return $posts;
    }

    /**
     * Retrieve all posts for a specific user.
     *
     * @param int $idUser ID of the user
     * @return array Returns an array of posts authored by the user
     */
    public function getUserPost(int $idUser) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT * FROM post WHERE idUser = ?");
        $stmt->execute([$idUser]); // Execute select query
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Fetch all posts for the user
    }
}
