<?php

namespace App\Controller;

use App\Framework\Get;
use App\Framework\Server;
use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\AbstractController;

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

        if (Get::existsDigit('id')) 
        {
            $idOfCategory = (int) Get::key('id');

            $categoryModel = new CategoryModel();
            $articlesByCategory = $categoryModel->getArticlesByCategory($idOfCategory);

            $pageTitle = 'Articles par catégorie';

            if(!$articlesByCategory)
            {
                FlashBag::addFlash('Aucune catégorie ne correspond à cet identifiant ou aucun article n\'a encore été écrit dans celle-ci.', 'error');
                return $this->redirect('forum');
            }
        }
        else
        {
            return $this->redirect('forum');
        }

        return $this->render('category', [
            'articlesByCategory' => $articlesByCategory??'',
            'pageTitle' => $pageTitle??''
        ]);
   }

   /**
    * (Moteur de recherche version PHP/MySQL)
    */
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

    /**
     * Moteur de recherche version AJAX
     */
   public function searchAjax()
   {
        if(Server::ajaxIsOkay())
        {
            /**
             * On récupère la valeur de $_POST['search'] venant du formulaire dans $search.
             */
            $search = trim(htmlspecialchars($_POST['search']));
            /**
             * On créé l'objet ArticleModel
             */
            $articleModel = new ArticleModel();

            /**
             * On stocke dans $searchArticles l'appel à la méthode searchArticles de l'objet $articleModel en donnant en paramètre ce que l'on a récupéré du formulaire.
             */
            $searchArticles = $articleModel->searchArticle($search);

            /**
             * On effectue une boucle foreach clé-valeur.
             */
            foreach ($searchArticles as $index => $searchArticle)
            {
                /**
                 * On ajoute une clé supplémentaire avec une valeur que l'on nomme. Et on donne l'adresse complète que l'on renvoie ensuite.
                 */
                $searchArticles[$index]['articleUrl'] = SITE_BASE_URL . buildUrl('article', ['id' => intval($searchArticle['id_article'])]);
                $searchArticles[$index]['categoryUrl'] = SITE_BASE_URL . buildUrl('category', ['id' => intval($searchArticle['id_category'])]);
            }

            /**
             * On récupère le résultat dans searchArticlesAjax depuis le json_encode qui prend en paramètre l'intégralité du résultat.
             */
            $searchArticlesAjax = json_encode($searchArticles);  
            
            /**
             * On fait un echo du résultat afin que la requête Ajax de JavaScript récupère les résultats.
             */
            echo $searchArticlesAjax;
       }
       else
       {
           return $this->redirect('search');
       }
 
       
   }
}