<?php

namespace App\Models;

use App\Database;
use PDO;

class PostLike {

    /**
     * Check if a user has liked a specific post.
     *
     * @param int $postId ID of the post
     * @param int $userId ID of the user
     * @return bool Returns true if the user has liked the post, false otherwise
     */
    public static function isLikedByUser($postId, $userId) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `likes` WHERE idPost = ? AND idUser = ?");
        $stmt->execute([$postId, $userId]); // Execute query to count likes by this user
        return $stmt->fetchColumn() > 0; // Return true if count > 0
    }

    /**
     * Count the total number of likes for a post.
     *
     * @param int $postId ID of the post
     * @return int Returns the total like count
     */
    public static function countLikes($postId) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `likes` WHERE idPost = ?");
        $stmt->execute([$postId]); // Execute query to count likes
        return (int)$stmt->fetchColumn(); // Return like count as integer
    }

    /**
     * Add a like to a post by a user.
     *
     * Only adds the like if the user has not already liked the post.
     *
     * @param int $postId ID of the post
     * @param int $userId ID of the user
     * @return int Returns the updated total number of likes for the post
     */
    public static function like($postId, $userId) {
        $pdo = Database::getInstance(); // Get database connection
        if (!self::isLikedByUser($postId, $userId)) {
            $stmt = $pdo->prepare("INSERT INTO `likes` (number, idUser, idPost) VALUES (1, ?, ?)");
            $stmt->execute([$userId, $postId]); // Insert new like
        }
        return self::countLikes($postId); // Return updated like count
    }

    /**
     * Remove a like from a post by a user.
     *
     * @param int $postId ID of the post
     * @param int $userId ID of the user
     * @return int Returns the updated total number of likes for the post
     */
    public static function unlike($postId, $userId) {
        $pdo = Database::getInstance(); // Get database connection
        $stmt = $pdo->prepare("DELETE FROM `likes` WHERE idPost = ? AND idUser = ?");
        $stmt->execute([$postId, $userId]); // Delete the like
        return self::countLikes($postId); // Return updated like count
    }
}
