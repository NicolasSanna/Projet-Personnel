<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;

class ForumController extends AbstractController
{
    public function index()
    {
        $articlesModel = new ArticleModel();

        $articles = $articlesModel->getAllArticles();

        return $this->render('forum', [
            'articles' => $articles
        ]);
   }
}