<?php

// On indique l'espace de nom, namespace : App\Model (composer.json : src/Model).
namespace App\Model;

// On utilise l'AbstractModel. (composer.json : src/App/Framework/AbstractModel).
use App\Framework\AbstractModel;

/**
 * On créé la classe Article Model. Celle-ci hérite des propriétés de l'AbstractModel qui créé l'objet Database et qui est rangé dans $this->database.
 */
class ArticleModel extends AbstractModel
{
    /**
     * On créé une méthode getAllArticles().
     */
    public function getAllArticles()
    {
        // On range dans $sql la requête SQL à effectuer. Ici, l'appel d'une procédure stockée MySQL.
        $sql = 'CALL SP_AllArticlesOrderByDateSelect ()';

        // On range dans $articles l'appel de la méthode getAllResults prenant en paramètre la requête SQL à partir de l'objet database hérité de l'AbstractModel.
        $articles = $this->database->getAllResults($sql);

        // On retourne le résultat : les articles.
        return $articles;
    }

    public function getLastTwoArticles()
    {
        $sql = 'CALL SP_TwoArticlesOrderByDateSelect()';

        $lastFiveArticles = $this->database->getAllResults($sql);

        return $lastFiveArticles;
    }

    /**
     * On créé une méthode getOneArticle qui prend en paramètre un nombre, l'identifiant de l'article.
     */
    public function getOneArticle(int $idOfArticle)
    {
        // On range dans $sql la requête SQL à effectuer, ici, l'appel d'une procédure stockée avec un paramètre anonyme, l'identifiant de l'article.
        $sql = 'CALL SP_ArticleSelect(?)';

        // On range dans $article l'exécution de la requête SQL depuis l'héritage de $this->database avec la méthode getOneResult ayant en paramètre la requête SQL, et le tableau contenant un élément, l'identifiant à aller récupérer en base de données.
        $article = $this->database->getOneResult($sql, [$idOfArticle]);

        // On retourne $article.
        return $article;
    }

    public function getOneArticleToUpdateForUser(int $idOfArticle)
    {
        // On range dans $sql la requête SQL à effectuer, ici, l'appel d'une procédure stockée avec un paramètre anonyme, l'identifiant de l'article.
        $sql = 'CALL SP_ArticleToUpdateForUser (?)';

        // On range dans $article l'exécution de la requête SQL depuis l'héritage de $this->database avec la méthode getOneResult ayant en paramètre la requête SQL, et le tableau contenant un élément, l'identifiant à aller récupérer en base de données.
        $article = $this->database->getOneResult($sql, [$idOfArticle]);

        // On retourne $article.
        return $article;
    }

    public function getOneArticleToUpdate(int $idOfArticle)
    {
        // On range dans $sql la requête SQL à effectuer, ici, l'appel d'une procédure stockée avec un paramètre anonyme, l'identifiant de l'article.
        $sql = 'CALL SP_ArticleToUpdateSelect(?)';

        // On range dans $article l'exécution de la requête SQL depuis l'héritage de $this->database avec la méthode getOneResult ayant en paramètre la requête SQL, et le tableau contenant un élément, l'identifiant à aller récupérer en base de données.
        $article = $this->database->getOneResult($sql, [$idOfArticle]);

        // On retourne $article.
        return $article;
    }


    /**
     * On créé une méthode insertArticle qui reçoit en paramètre le title, le content, l'identifiant de catégorie, l'identifiant utilisateur, et le nom de l'image qui par défaut est null car il est possible d'ajouter ou non une image. 
     */
    public function insertArticle(string $title, string $content, int $category_id, int $user_id, string $image = null)
    {

        // On range dans $sql la chaîne représentant la requête SQL. Ici, l'appel d'une procédure stockée prenant en paramètre ce que la méthode a reçu.
        $sql = 'CALL SP_ArticleInsert(?, ?, ?, ?, ?)';

        // On exécute la requête SQL avec les paramètres en allant chercher la méthode située dans database (hérité de AbstractModel).
        $insertArticleId = $this->database->insert($sql, [$title, $content, $category_id, $user_id, $image]);

        // On renvoie le résultat.
        return $insertArticleId;
    }

    /**
     * On créé une méthode getMyArticles() elle prend en paramètre le numéro d'identifiant de l'utilisateur en session (userId).
     */
    public function getMyArticles(int $userId)
    {
        // On range dans $sql la requête SQL qui permet de récupérer les articles de l'utilisateur grâce au paramètre donné à la procédure stockée MySQL.
        $sql = 'CALL SP_MyArticlesSelect(?)';

        // On range dans $getMyArticles l'exécution de la requête SQL avec en paramètre le numéro d'identifiant grâce à la méthode getAllResults venant de l'objet Database dont on hérite grâce à AbstractModel.
        $getMyArticles = $this->database->getAllResults($sql, [$userId]);

        // On renvoie le résultat.
        return $getMyArticles;
    }

    /**
     * On créé une méthode deleteArticle qui prend en paramètre l'identifiant de l'article à supprimer et l'auteur de celui-ci.
     */
    public function deleteArticle(int $articleId, int $userId)
    {
        // On range dans $sql la requête SQL qui prend en paramètre l'identifiant de l'article et son auteur qui veut le supprimer. Ici en procédure stockée.
        $sql = 'CALL SP_ArticleDelete(?, ?)';

        // On range dans $deleteArticle l'exécution de la requête SQL qui a pris en paramètre l'article et l'utilisateur.
        $deleteArticle = $this->database->executeQuery($sql, [$articleId, $userId]);

        // On renvoie le résultat.
        return $deleteArticle;
    }

    /**
     * On créé la méthode modifyArticle qui prend en paramètre le numéro d'identifiant de l'article, l'utilisateur, le nouveau titre, le nouveau contenu, la nouvelle catégorie et l'image. Par défaut, l'image est à null car on peut ne pas vouloir mettre d'image.
     */
    public function modifyarticle(int $articleId, int $userId, string $newtitle, string $newcontent, int $newcategory, string $image = null)
    {
        // On range dans $sql la requête SQL qui va réaliser l'opération, grâce aux paramètres qu'on lui donne.
        $sql = 'CALL SP_ArticleUpdate(?, ?, ?, ?, ?, ?)';

        // On exécute la requête SQL grâce aux paramètres du tableau.
        $updateArticle = $this->database->executeQuery($sql, [$articleId, $userId, $newtitle, $newcontent, $newcategory, $image]);

        // On renvoie le résultat.
        return $updateArticle;
    }

    /**
     * On créé une méthode searchArticle qui prend en paramètre une chaîne de caractères.
     */
    public function searchArticle(string $searchArticle)
    {
        // On range dans $sql la requête SQL à effectuer dans la base de données et on lui donne en paramètre la chaine de caractèreq contenant ce que l'on désire chercher.
        $sql = 'CALL SP_SearchSelect(?)';

        // On range le résultat de la requête SQL celle-ci une fois exécutée avec les paramètres dans une variable.
        $searchAnArticle = $this->database->getAllResults($sql, [$searchArticle]);

        // On renvoie le résultat.
        return $searchAnArticle;
    }

    /**
     * On créé une méthode deleteImageArticle qui prend en paramètre l'identifiant de l'article.
     */
    public function deleteImageArticle(int $idOfArticle)
    {
        // On range dans $sql la requête SQL que l'on veut effectuer. Elle prend en paramètre l'identifiant de l'article dont on va retirer l'image.
        $sql = 'CALL SP_ArticleImageUpdate(?)';

        // On renvoie le résultat de l'exécution de la requête SQL.
        $deleteImageArticle = $this->database->executeQuery($sql, [$idOfArticle]);

        // On retourne le résultat.
        return $deleteImageArticle;
    }

    public function allArticlesNotApprouved()
    {
        $sql = 'CALL SP_ArticlesNotApprouvedSelect()';

        $allArticlesNotAppourved = $this->database->getAllResults($sql);

        return $allArticlesNotAppourved;
    }

    public function approuveArticle(int $idOfArticle)
    {
        $sql = 'CALL SP_ApprouveArticleUpdate (?)';

        $approuveArticle = $this->database->executeQuery($sql, [$idOfArticle]);
    }

    public function deleteNotApprouvedArticle (int $idOfArticle)
    {
        $sql = 'CALL SP_NotApprouvedArticleDelete (?)';

        $deleteNotApprouvedArticle = $this->database->executeQuery($sql, [$idOfArticle]);
    }
}