<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;
use App\Framework\FlashBag;

class ArticleController extends AbstractController
{
    public function index()
    {
        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id'])) 
        {
            $idOfArticle = (int) $_GET['id'];

            $articleModel = new ArticleModel();

            $article = $articleModel->getOneArticle($idOfArticle);

            if(!empty($article['id']))
            {
                return $this->render('article', [
                    'article' => $article
                ]);
            }
            else
            {
                FlashBag::addFlash('Aucun article ne correspond à cet identifiant.');
                return $this->redirect('forum');
            }
        }
    }
}