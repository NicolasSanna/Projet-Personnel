<?php

/**
 * Création du namespace App\Framework (composer.json : App\\:src/)
 */
namespace App\Framework;

use App\Framework\UserSession;

/**
 * Création de la classe Server chargée des différentes opérations sur la superglobale $_SERVER qui contient toutes les informations relatives aux reuqêtes HTTP, etc.
 */
class Server 
{

    /**
     * Création de la fonction statique path. Sans paramètre.
     */
    static function path ()
    {
        /**
         * On stocke dans la variable $fullPath la totalité de l'adresse (requête) HTTP du navigateur. Si elle est null, on met à la place le / qui désigne l'entrée du site (pas d'éléments supplémentaires dans l'adresse).
         */
        $fullPath = $_SERVER['REQUEST_URI'] ?? '/';

        /**
         * Avec la fonction explode, on désigne le point de rupture, (le ? de PHP qui indique un paramètre dans l'URL de type $_GET). en second paramètre on indique quelle partie de l'URL explosée on souhaite récupérer, ici, la partie avant le point d'interrogation pour trouver le bon contrôleur. [0] case avant le ?, [1] après le ?. Car c'est un tableau.
         */
        $path = explode('?', $fullPath)[0];

        if(!self::secureAdmin($path))
        {
            $path = '/accessRefuse';

                return $path;
        }

        /**
         * On renvoie le path.
        */
        return $path;
        
    }

    /**
     * Création de la fonction statique verifyAjax qui contrôle si c'est une requête Ajax qui est reçue.
     */
    static function ajaxIsOkay()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
        {
            return true;
        }
    }

    static function secureAdmin(string $path): bool
    {
        if (str_contains($path, '/administration') && !UserSession::isAuthenticated())
        {
            return false;
        }

        return true;
    }
}