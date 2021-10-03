<?php

namespace App\Model;

use App\Framework\AbstractModel;

class ArticleModel extends AbstractModel
{
    function getAllArticles()
    {
        $sql = 'CALL SP_SelectAllArticlesOrderByDate ()';

        $articles = $this->database->getAllResults($sql);

        return $articles;
    }

    function getOneArticle($idOfArticle)
    {
        $sql = 'CALL SP_SelectArticle(?)';

        $article = $this->database->getOneResult($sql, [$idOfArticle]);

        return $article;
    }

    function insertArticle($title, $content, $category_id, $user_id)
    {
        $sql ='CALL SP_ArticleCreate(?, ?, ?, ?)';

        $insertArticle = $this->database->executeQuery($sql, [$title, $content, $category_id, $user_id]);

        return $insertArticle;

    }
}