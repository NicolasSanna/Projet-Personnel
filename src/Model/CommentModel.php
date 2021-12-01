<?php

// Espace de nom App\Model (composer.json : src/App/Model).
namespace App\Model;

// On va utiliser App\Framework\AbstractModel (composer.json : src/Framework/AbstractModel).
use App\Framework\AbstractModel;

// On créé une classe CommentModel qui va hériter des propriétés de l'AbstractModel.
class CommentModel extends AbstractModel
{
    // On créé une méthode addComment qui prend en paramètre la chaîne de caractères du commentaire, le numéro d'identifiant de l'utilisateur et le numéro d'identifiant de l'article.
    public function addComment(string $comment, int $userId, int $articleId)
    {
        // On stocke la requête SQL. L'appel de la procédure stockée elle prend les trois paramètres anonymes : le commentaire, l'identifiant utilisateur, et le numéro d'article.
        $sql = 'CALL SP_CommentInsert(?, ?, ?)';

        // On stocke dans insertComment le résultat de l'exécution de la procédure stockée depuis l'objet database et sa méthode executeQuery.
        $insertComment = $this->database->executeQuery($sql, [$comment, $userId, $articleId]);

        // On retourne le résultat.
        return $insertComment;
    }

    // On créé une fonction getAllComments qui prend en paramètre le numéro d'identifiant de l'article (tous les commentaires d'un seul article).
    public function getAllComments(int $articleId)
    {
        // On stocke dans $sql la requête à effectuer, l'appel de la procédure stockée qui prend le numéro d'identifiant de l'article comme paramètre anonyme.
        $sql = 'CALL SP_AllCommentsArticleSelect(?)';

        // On stocke le résultat dans $getAllComment à partir de la méthode getAllResults et des paramètres données pour son exécution dans l'objet database.
        $getAllcomment = $this->database->getAllResults($sql, [$articleId]);

        // On récupère le résultat.
        return $getAllcomment;
    }

    // On créé une fonction getAllCommentsNotApprouved().
    public function getAllCommentsNotApprouved()
    {
        // On stocke dans $sql la requête à effectuer. Ici l'appel d'une procédure stockée.
        $sql = 'CALL SP_AllCommentsNotApprouvedSelect ()';

        // On stocke dans getAllCommentsNotApprouved le résultat de la requête issue de la méthode getAllResults de l'objet database.
        $getAllCommentsNotApprouved = $this->database->getAllResults($sql);

        // On retourne le résultat.
        return $getAllCommentsNotApprouved;
    }

    // On créé une méthode getOneComment qui prend en paramètre le numéro d'identifiant du commentaire.
    public function getOneComment(int $commentId)
    {
        // On stocke dans $sql l'appel de la procédure stockée qui prend le numéro d'identifiant comme paramètre anonyme. 
        $sql = 'CALL SP_OneCommentSelect(?)';

        // On stocke le résultat de l'exécution de la requête dans l'objet database et sa méthode getOneResult.
        $getOneComment = $this->database->getOneResult($sql, [$commentId]);

        // On retourne le résultat.
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