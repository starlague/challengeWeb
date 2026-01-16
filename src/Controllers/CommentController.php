<?php
namespace App\Controllers;

use App\Models\Comment;

class CommentController {

    public function createComment($idPost, $idUser, $content) {
        $idComment = Comment::create($idPost, $idUser, $content);
        return ['id' => $idComment, 'isAuthor' => true]; // The author is always the current user
    }

    public function getCommentsForPost($idPost) {
        return Comment::getByPost($idPost);
    }

    public function deleteComment($idComment, $idUser) {
        Comment::delete($idComment, $idUser);
    }
}
