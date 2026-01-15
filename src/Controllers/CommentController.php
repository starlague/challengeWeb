<?php
namespace App\Controllers;

use App\Models\Comment;

class CommentController {

    public function createComment($idPost, $idUser, $content) {
        Comment::create($idPost, $idUser, $content);
    }

    public function getCommentsForPost($idPost) {
        return Comment::getByPost($idPost);
    }
}
