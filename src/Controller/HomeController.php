<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;

class HomeController extends AbstractController 
{

    public function index()
    {
        $pageTitle = 'Bienvenue';

        $articlesModel = new ArticleModel();

        $articles = $articlesModel->getAllArticles();

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
}
