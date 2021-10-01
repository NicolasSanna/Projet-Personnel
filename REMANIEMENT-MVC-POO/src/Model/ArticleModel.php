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
}