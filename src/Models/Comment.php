<?php
namespace App\Models;

use App\Database;
use PDO;

class Comment {

    /**
     * Create a new comment for a post.
     *
     * Inserts a comment into the database and returns its ID.
     *
     * @param int $idPost ID of the post to comment on
     * @param int $idUser ID of the user creating the comment
     * @param string $content Content of the comment
     * @return string Returns the ID of the newly created comment
     */
    public static function create($idPost, $idUser, $content) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("INSERT INTO `comment` (idPost, idUser, content) VALUES (?, ?, ?)");
        $stmt->execute([$idPost, $idUser, $content]); // Execute insert query
        return $pdo->lastInsertId(); // Return the ID of the inserted comment
    }

    /**
     * Retrieve all comments for a specific post.
     *
     * Joins with the users table to get the username for each comment.
     * Comments are sorted in ascending order by ID.
     *
     * @param int $idPost ID of the post
     * @return array Returns an array of comments with user info
     */
    public static function getByPost($idPost) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("
            SELECT c.*, u.username
            FROM comment c
            JOIN users u ON c.idUser = u.id
            WHERE c.idPost = ?
            ORDER BY c.id ASC
        ");
        $stmt->execute([$idPost]); // Execute select query
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all comments as associative array
    }

    /**
     * Delete a comment from the database.
     *
     * Only deletes the comment if it belongs to the specified user.
     *
     * @param int $idComment ID of the comment to delete
     * @param int $idUser ID of the user attempting to delete the comment
     * @return void
     */
    public static function delete($idComment, $idUser) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("DELETE FROM comment WHERE id = ? AND idUser = ?");
        $stmt->execute([$idComment, $idUser]); // Execute delete query
    }
}
