<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;

class ArticleController extends AbstractController
{
    public function index()
    {
        if (array_key_exists('id', $_GET) || !$_GET['id'] || ctype_digit($_GET['id'])) 
        {
            $idOfArticle = (int) $_GET['id'];

            $articleModel = new ArticleModel();

            $article = $articleModel->getOneArticle($idOfArticle);

            return $this->render('article', [
                'article' => $article
            ]);
        }
    }
}