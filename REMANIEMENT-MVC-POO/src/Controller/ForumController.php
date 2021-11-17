<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\FlashBag;

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

   public function seeAllCategories()
   {

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategoriesForForum();

        return $this->render('categories', [
            'categories' => $categories
        ]);
   }

   public function seeOneCategoryAndArticles()
   {

        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id']))
        {

            $idOfCategory = $_GET['id'];

            $categoryModel = new CategoryModel();
            $articlesByCategory = $categoryModel->getArticlesByCategory($idOfCategory);

            if(empty($articlesByCategory))
            {
                FlashBag::addFlash("Il n'y a aucun article encore dans cette catégorie.", 'error');
                $this->redirect('forum');
            }
  
        }
        else
        {

            $this->redirect('forum');

        }

        return $this->render('category', [
            'articlesByCategory' => $articlesByCategory
        ]);
   }
}