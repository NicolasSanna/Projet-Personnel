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
        $sql ='CALL SP_ArticleInsert(?, ?, ?, ?)';

        $insertArticleId = $this->database->insert($sql, [$title, $content, $category_id, $user_id]);

        if(!is_null($image))
        {
            $sql = 'UPDATE articles
                    SET image = ?
                    WHERE id = ?';

            $this->database->executeQuery($sql, [$image, $insertArticleId]);
        }

        return $insertArticleId;

    }

    function getMyArticles($userId)
    {
        $sql = 'CALL SP_MyArticlesSelect(?)';

        $getMyArticles = $this->database->getAllResults($sql, [$userId]);

        return $getMyArticles;
    }

    function deleteArticle($articleId, $userId)
    {
        $sql = 'CALL SP_ArticleDelete(?, ?)';

        $deleteArticle = $this->database->executeQuery($sql, [$articleId, $userId]);

        return $deleteArticle;
    }

    function modifyarticle($articleId, $userId, $newtitle, $newcontent, $newcategory)
    {
        $sql = 'CALL SP_ArticleUpdate(?, ?, ?, ?, ?)';

        $updateArticle = $this->database->executeQuery($sql, [$articleId, $userId, $newtitle, $newcontent, $newcategory]);

        return $updateArticle;
    }

    function searchArticle(string $searchArticle)
    {
        $sql = 'CALL SP_SearchSelect(?)';

        $searchAnArticle = $this->database->getAllResults($sql, [$searchArticle]);

        return $searchAnArticle;
    }
}