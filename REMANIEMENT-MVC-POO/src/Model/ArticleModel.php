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
}