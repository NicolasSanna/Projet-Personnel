<?php 

namespace App\Controller;

use App\Model\ArticleModel;
use App\Framework\AbstractController;

class HomeController extends AbstractController 
{

    public function index()
    {
        $pageTitle = 'Bienvenue';

        $articlesModel = new ArticleModel();

        $articles = $articlesModel->getLastTwoArticles();

        return $this->render('home', [
            'articles' => $articles??'',
            'pageTitle' => $pageTitle??''
        ]);
       
    }

    public function refused()
    {
        $pageTitle = 'Accès Refusé';
        return $this->render('accessRefused', [
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        return $this->render('404', [
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function mentionslegales()
    {
         $pageTitle = 'Mentions légales';
 
         return $this->render('mentionslegales', [
             'pageTitle' => $pageTitle
         ]);
    }
}
