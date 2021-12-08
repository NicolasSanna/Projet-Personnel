<?php

// On indique l'espace de nom (composer.json : src/Controller/Admin)
namespace App\Controller\Admin;

// On indique l'utilisation de l'AbstractController.
use App\Framework\AbstractController;
// On indique l'utilisation de UserSession.
use App\Framework\UserSession;

// On créé la classe AdministrationController qui hérite des propriétés de AbstractController.
class AdministrationController extends AbstractController
{
    // On créé une méthode publique index.
    public function index()
    {
        // Si UserSession::isAuthenticated n'est pas déclaré...
        if(!UserSession::isAuthenticated())
        {
            // ... On est redirigé vers la route accessRefused du tableau de routes.
            $this->redirect('accessRefused');
        }

        // On indique le titre de la page qui s'affichera dans l'entête de l'onglet de page.
        $pageTitle = 'Administration';

        // On retourne grâce à la méthode render venant de l'AbstractController le bon template et on donne en paramètre les variables pour leur affichage dans le template. 
        return $this->render('admin/administration', [
            'pageTitle' => $pageTitle??''
        ]);
    }
}