<?php

namespace App\Model;

use App\Framework\AbstractModel;

class ArticleModel extends AbstractModel
{
    function getAllArticles()
    {
        $sql = 'CALL SP_AllArticlesOrderByDateSelect ()';

        $articles = $this->database->getAllResults($sql);

        return $articles;
    }

    function getOneArticle(int $idOfArticle)
    {
        $sql = 'CALL SP_ArticleSelect(?)';

        $article = $this->database->getOneResult($sql, [$idOfArticle]);

        return $article;
    }

    function insertArticle(string $title, string $content, int $category_id, int $user_id, string $image = null)
    {
        $sql ='CALL SP_ArticleInsert(?, ?, ?, ?, ?)';

        $insertArticleId = $this->database->insert($sql, [$title, $content, $category_id, $user_id, $image]);

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