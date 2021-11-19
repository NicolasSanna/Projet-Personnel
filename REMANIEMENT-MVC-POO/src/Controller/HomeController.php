<?php 

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;

class HomeController extends AbstractController 
{

    public function index()
    {
        // Affichage : inclusion du template
        return $this->render('Home', [
            'message' => 'Bienvenue sur l\'Accueil'
        ]);
    }

    public function refused()
    {
        return $this->render('accessRefused');
    }

    public function notFound()
    {
        return $this->render('404');
    }
}
