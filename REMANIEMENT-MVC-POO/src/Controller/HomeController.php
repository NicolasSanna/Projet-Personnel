<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;

class HomeController extends AbstractController 
{

    public function index()
    {
        $pageTitle = 'Bienvenue';
        // Affichage : inclusion du template
        return $this->render('Home', [
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
