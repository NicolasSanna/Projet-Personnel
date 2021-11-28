<?php

// On indique l'espace de nom, namespace : App\Model (composer.json : src/Model).
namespace App\Model;

// On utilise l'AbstractModel. (composer.json : src/App/Framework/AbstractModel).
use App\Framework\AbstractModel;

// On créé la classe Article Model. Celle-ci hérite des propriétés de l'AbstractModel qui créé l'objet Database et qui est rangé dans $this->database.
class ArticleModel extends AbstractModel
{
    // On créé une méthode getAllArticles().
    function getAllArticles()
    {
        // On range dans $sql la requête SQL à effectuer. Ici, l'appel d'une procédure stockée MySQL.
        $sql = 'CALL SP_AllArticlesOrderByDateSelect ()';

        // On range dans $articles l'appel de la méthode getAllResults prenant en paramètre la requête SQL à partir de l'objet database hérité de l'AbstractModel.
        $articles = $this->database->getAllResults($sql);

        // On retourne le résultat : les articles.
        return $articles;
    }

    // On créé une méthode getOneArticle qui prend en paramètre un nombre, l'identifiant de l'article.
    function getOneArticle(int $idOfArticle)
    {
        // On range dans $sql la requête SQL à effectuer, ici, l'appel d'une procédure stockée avec un paramètre anonyme, l'identifiant de l'article.
        $sql = 'CALL SP_ArticleSelect(?)';

        // On range dans $article l'exécution de la requête SQL depuis l'héritage de $this->database avec la méthode getOneResult ayant en paramètre la requête SQL, et le tableau contenant un élément, l'identifiant à aller récupérer en base de données.
        $article = $this->database->getOneResult($sql, [$idOfArticle]);

        // On retourne $article.
        return $article;
    }

    // On créé une méthode insertArticle qui reçoit en paramètre le title, le content, l'identifiant de catégorie, l'identifiant utilisateur, et le nom de l'image qui par défaut est null car il est possible d'ajouter ou non une image. 
    function insertArticle(string $title, string $content, int $category_id, int $user_id, string $image = null)
    {

        // On range dans $sql la chaîne représentant la requête SQL. Ici, l'appel d'une procédure stockée prenant en paramètre ce que la méthode a reçu.
        $sql = 'CALL SP_ArticleInsert(?, ?, ?, ?, ?)';

        // On exécute la requête SQL avec les paramètres en allant chercher la méthode située dans database (hérité de AbstractModel).
        $insertArticleId = $this->database->insert($sql, [$title, $content, $category_id, $user_id, $image]);

        // On renvoie le résultat.
        return $insertArticleId;
    }

    function getMyArticles(int $userId)
    {
        $sql = 'CALL SP_MyArticlesSelect(?)';

        $getMyArticles = $this->database->getAllResults($sql, [$userId]);

        return $getMyArticles;
    }

    function deleteArticle(int $articleId, int $userId)
    {
        $sql = 'CALL SP_ArticleDelete(?, ?)';

        $deleteArticle = $this->database->executeQuery($sql, [$articleId, $userId]);

        return $deleteArticle;
    }

    function modifyarticle(int $articleId, int $userId, string $newtitle, string $newcontent, int $newcategory, string $image = null)
    {
        $sql = 'CALL SP_ArticleUpdate(?, ?, ?, ?, ?, ?)';

        $updateArticle = $this->database->executeQuery($sql, [$articleId, $userId, $newtitle, $newcontent, $newcategory, $image]);

        return $updateArticle;
    }

    function searchArticle(string $searchArticle)
    {
        $sql = 'CALL SP_SearchSelect(?)';

        $searchAnArticle = $this->database->getAllResults($sql, [$searchArticle]);

        return $searchAnArticle;
    }

    function deleteImageArticle(int $idOfArticle)
    {
        $sql = 'CALL SP_ArticleImageUpdate(?)';

        $deleteImageArticle = $this->database->executeQuery($sql, [$idOfArticle]);

        return $deleteImageArticle;
    }
}