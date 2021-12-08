<?php 

// On indique l'espace de nom : App\Framework (composer.json : src/Framework).
namespace App\Framework;

/**
 * On créé la classe UserSession.
 */
class UserSession extends AbstractSession
{
    /**
     * Enregistre les informations de l'utilisateur en session venant du formulaire de connexion et avec les informations relatives venant de la base de données.
     */
    static function register(int $userId, string $firstname, string $lastname, string $pseudo, string $email, int $grant_id, string $grant_label)
    {

           // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck().
           self::sessionCheck();
        // On créé une clé User dans la superglobal $_SESSION qui est un tableau associatif contenant les diverses informations relatives à l'utilisation qui s'est connecté.
        $_SESSION['user'] = [
            'userId' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudo' => $pseudo,
            'email' => $email,
            'grant_id' => $grant_id,
            'grant_label' => $grant_label
        ];

        // On appelle la méthode privée token afin de générer le token aléatoire lors de la connexion de l'utilisateur.
        self::token();

    }

    /**
     * On créé une méthode statique is authenticated.
     */
    static function isAuthenticated()
    {
        // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck().
        self::sessionCheck();

        // On retourne le tableau contenant la clé user et si est bien déclarée $_SESSION['user'];
        return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
    }

    /**
     * On créé une méthode statique logout.
     */
    static function logout()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne.
        if (!self::isAuthenticated())
        {
            return;
        }

        // Sinon, on met la clé 'user' à null, et on vide la session.
        $_SESSION['user'] = null;
        session_destroy();
    }

    /**
     * On créé une méthode statique getId.
     */
    static function getId()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }

        // Sinon on retourne l'identifiant userId venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['userId'];
    }

    /**
     * On créé une méthode statique getFirstname()
     */
    static function getFirstname()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
        // Sinon on retourne l'identifiant firstname venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['firstname'];
    }

    /**
     * On créé une méthode statique getFirstname()
     */
    static function getLastname()
    {
         // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
        // Sinon on retourne l'identifiant lastname venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['lastname'];
    }

    /**
     * Retourne le nom complet de l'utilisateur connecté
     */
    static function getUserFullname()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }

        return $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
    }

    /**
     * On créé une méthode statique getFirstname()
     */
    static function getEmail()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }

        // Sinon on retourne l'identifiant email venant de la clé user de la superlogable $_SESSION.
        return $_SESSION['user']['email'];
    }
    
    /**
     * On créé une méthode statique administrator()
     */
    static function administrator()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }

        // On retourne l'identifiant du grant_id venant de la base de données en fonction de l'utilisateur en session. Ici 1.
        return $_SESSION['user']['grant_label'] == "['ROLE_ADMINISTRATOR']";
    }

    /**
     * On créé une méthode statique author()
     */
    static function author()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }

        // On retourne l'identifiant du grant_id venant de la base de données en fonction de l'utilisateur en session. Ici 2.
        return $_SESSION['user']['grant_label'] == "['ROLE_AUTHOR']";
    }

    /**
     * On créé une méthode statique newRegistered()
     */
    static function newRegistered()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
        // On retourne l'identifiant du grant_id venant de la base de données en fonction de l'utilisateur en session. Ici 3.
        return $_SESSION['user']['grant_label'] == "['ROLE_NEW_USER']";
    }

    /**
     * On créé une fonction statique token().
     */
    static function token()
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
     
        // Si $_SESSION['user']['token'] n'est pas déclarée...
        if(!isset($_SESSION['user']['token']))
        {
            // On créé la clé token dans user dans $_SESSION et qui reçoit une chaîne de caractères composées de chiffres et de lettres aléatoires et qui change à chaque connexion.
            $_SESSION['user']['token'] = bin2hex(openssl_random_pseudo_bytes(24));
        }

        // On retourne le token.
        return $_SESSION['user']['token'];
    }
}