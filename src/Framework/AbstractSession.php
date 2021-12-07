<?php 

namespace App\Framework;

/**
 * Création de la classe abstraite AbstractSession. Elle démarre la session et elle peut être héritable pour la classe FlashBag et
 */
abstract class AbstractSession 
{

    /**
    * On créé le constructeur. Il appelle la fonction sessionCheck()
    */
    public function __construct()
    {
        $this->sessionCheck();
    }

    /**
    * Démarre une session si aucune session n'est démarrée
    */
    static function sessionCheck()
    {
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_start();
        }
    }
}