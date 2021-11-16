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

    public function getAllCommentsNotApprouved()
    {
        $sql = 'CALL SP_GetAllCommentsNotApprouved ()';

        $getAllCommentsNotApprouved = $this->database->getAllResults($sql);

        return $getAllCommentsNotApprouved;
    }

    public function getOneComment(int $commentId)
    {
        $sql = 'CALL SP_GetOneComment(?)';
        $getOneComment = $this->database->getOneResult($sql, [$commentId]);

        return $getOneComment;
    }

    public function commentApprouved(int $commentId)
    {
        $sql = 'CALL SP_CommentApprouved(?)';

        $approuvedComment = $this->database->executeQuery($sql, [$commentId]);
    }

    public function commentDelete(int $commentId)
    {
        $sql = 'CALL SP_CommentDelete(?)';

        $deleteComment = $this->database->executeQuery($sql, [$commentId]);
    }

    public function AllCommentsApprouved()
    {
        $sql = 'CALL SP_AllCommentsApprouved ()';

        $allCommentsApprouved = $this->database->executeQuery($sql);
    }
}