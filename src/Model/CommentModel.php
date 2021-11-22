<?php

namespace App\Model;

use App\Framework\AbstractModel;

class CommentModel extends AbstractModel
{
    public function addComment(string $comment, int $userId, int $articleId)
    {
        $sql = 'CALL SP_CommentInsert(?, ?, ?)';

        $insertComment = $this->database->executeQuery($sql, [$comment, $userId, $articleId]);

        return $insertComment;
    }

    public function getAllComments(int $articleId)
    {
        $sql = 'CALL SP_AllCommentsArticleSelect(?)';
        $getAllcomment = $this->database->getAllResults($sql, [$articleId]);
        return $getAllcomment;
    }

    public function getAllCommentsNotApprouved()
    {
        $sql = 'CALL SP_AllCommentsNotApprouvedSelect ()';

        $getAllCommentsNotApprouved = $this->database->getAllResults($sql);

        return $getAllCommentsNotApprouved;
    }

    public function getOneComment(int $commentId)
    {
        $sql = 'CALL SP_OneCommentSelect(?)';
        $getOneComment = $this->database->getOneResult($sql, [$commentId]);

        return $getOneComment;
    }

    public function commentApprouved(int $commentId)
    {
        $sql = 'CALL SP_CommentUpdate(?)';

        $approuvedComment = $this->database->executeQuery($sql, [$commentId]);
    }

    public function commentDelete(int $commentId)
    {
        $sql = 'CALL SP_CommentDelete(?)';

        $deleteComment = $this->database->executeQuery($sql, [$commentId]);
    }

    public function AllCommentsApprouved()
    {
        $sql = 'CALL SP_AllCommentsUpdate ()';

        $allCommentsApprouved = $this->database->executeQuery($sql);
    }
}