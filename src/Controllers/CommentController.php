<?php
namespace App\Controllers;

use App\Models\Comment;

class CommentController {

    /**
     * Create a new comment for a specific post by a specific user.
     *
     * @param int $idPost The ID of the post to comment on
     * @param int $idUser The ID of the user creating the comment
     * @param string $content The content of the comment
     * @return array Returns an array containing the new comment ID and author info
     */
    public function createComment($idPost, $idUser, $content) {
        $idComment = Comment::create($idPost, $idUser, $content);
        return ['id' => $idComment, 'isAuthor' => true]; // The author is always the current user
    }

    /**
     * Retrieve all comments for a given post.
     *
     * @param int $idPost The ID of the post
     * @return array Returns an array of Comment objects associated with the post
     */
    public function getCommentsForPost($idPost) {
        return Comment::getByPost($idPost);
    }

    /**
     * Delete a comment if the current user is the author.
     *
     * @param int $idComment The ID of the comment to delete
     * @param int $idUser The ID of the user attempting to delete the comment
     * @return void
     */
    public function deleteComment($idComment, $idUser) {
        Comment::delete($idComment, $idUser);
    }
}
