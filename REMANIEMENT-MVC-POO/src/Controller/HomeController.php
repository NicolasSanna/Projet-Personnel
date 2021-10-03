<?php 

namespace App\Controller;

use App\Framework\AbstractController;

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
}
