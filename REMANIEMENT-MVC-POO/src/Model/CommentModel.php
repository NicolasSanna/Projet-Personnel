<?php

namespace App\Model;

use App\Framework\AbstractModel;

class CommentModel extends AbstractModel
{
    public function addComment(string $comment, int $userId, int $articleId)
    {
        $sql = 'CALL SP_addComment(?, ?, ?)';

        $insertComment = $this->database->executeQuery($sql, [$comment, $userId, $articleId]);

        return $insertComment;
    }

    public function getAllComments(int $articleId)
    {
        $sql = 'CALL SP_GetAllComments(?)';
        $getAllcomment = $this->database->getAllResults($sql, [$articleId]);
        return $getAllcomment;
    }
}