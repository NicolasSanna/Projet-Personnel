<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;

class ForumController extends AbstractController
{
    public function index()
    {
        $articlesModel = new ArticleModel();

        $articles = $articlesModel->getAllArticles();

        $pageTitle = 'Forum';

        return $this->render('forum', [
            'articles' => $articles??'',
            'pageTitle' => $pageTitle??''
        ]);
   }

   public function seeAllCategories()
   {

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategoriesForForum();

        $pageTitle = 'Catégories';

        return $this->render('categories', [
            'categories' => $categories??'',
            'pageTitle' => $pageTitle??''
        ]);
   }

   public function seeOneCategoryAndArticles()
   {

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {

            $idOfCategory = $_GET['id'];

            $categoryModel = new CategoryModel();
            $articlesByCategory = $categoryModel->getArticlesByCategory($idOfCategory);

            $pageTitle = 'Articles par catégorie';

            if(!$articlesByCategory)
            {
                FlashBag::addFlash('Aucun article ne correspond à cet identifiant.', 'error');
                return $this->redirect('forum');
            }
        }
        else
        {
            $this->redirect('forum');
        }

        return $this->render('category', [
            'articlesByCategory' => $articlesByCategory??'',
            'pageTitle' => $pageTitle??''
        ]);
   }

   public function search()
   {
        $pageTitle = 'Rechercher';

       if(array_key_exists('search', $_GET) || isset($_GET['search']))
       {
           
            $search = trim(htmlspecialchars($_GET['search']));
        
            if(!$search)
            {
                FlashBag::addFlash("Le champ de recherche est vide.", 'error');
            }
            else
            {
                $articleModel = new ArticleModel();
                $searchArticles = $articleModel->searchArticle($search);

                if(empty($searchArticles))
                {
                    FlashBag::addFlash("Aucun article ne correspond à votre recherche.", 'error');
                }
            }
        }

        return $this->render('search', [
           'searchArticles' => $searchArticles??'',
           'search' => $search??'',
           'pageTitle' => $pageTitle??''
       ]);
   }
}