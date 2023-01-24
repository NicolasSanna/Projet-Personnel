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

        // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck(). C'est une méthode statique héritée de l'AbstractSession : pas besoin d'instancier le constructeur parent.
        self::sessionCheck();
        
        // On créé une clé User dans la superglobal $_SESSION qui est un tableau associatif contenant les diverses informations relatives à l'utilisation qui s'est connecté.
        $_SESSION['user'] = [
            'userId' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudo' => $pseudo,
            'email' => $email,
            'grant_id' => $grant_id,
            'grant_label' => $grant_label,
        ];

        self::token();

    }

    /**
     * On créé une méthode statique is authenticated.
     */
    static function isAuthenticated(): bool
    {
        // On s'assure que la session est bien démarrée en appelant la méthode sessionCheck().
        self::sessionCheck();

        if(array_key_exists('user', $_SESSION) && isset($_SESSION['user']) && !is_null($_SESSION['user']))
        {
            return true;
        }
        else
        {
            return false;
        }
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
    static function getId(): int
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

    static function getPseudo()
    {

        if (!self::isAuthenticated())
        {
            return null;
        }

        return $_SESSION['user']['pseudo'];
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

        if ($_SESSION['user']['grant_label'] === "['ROLE_ADMINISTRATOR']" && $_SESSION['user']['grant_id'] === 1)
        {
            return true;
        }
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

        if ($_SESSION['user']['grant_label'] === "['ROLE_AUTHOR']" && $_SESSION['user']['grant_id'] === 2)
        {
            return true;
        }
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

        if ($_SESSION['user']['grant_label'] === "['ROLE_NEW_USER']" && $_SESSION['user']['grant_id'] === 3)
        {
            return true;
        }
    }

    /**
     * On créé une fonction statique token().
     */
    static function token(): null|string
    {
        // Si à l'appel de la méthode statique isAuthenticated() il n'y a rien on retourne null.
        if (!self::isAuthenticated())
        {
            return null;
        }
     
        // Si $_SESSION['user']['token'] n'est pas déclarée ou est vide...
        if(!isset($_SESSION['user']['token']) || empty($_SESSION['user']['token']) || is_null($_SESSION['user']['token']))
        {
            // On créé la clé token dans user dans $_SESSION et qui reçoit une chaîne de caractères composées de chiffres et de lettres aléatoires et qui change à chaque connexion.
            $_SESSION['user']['token'] = bin2hex(openssl_random_pseudo_bytes(24));
        }

        // On retourne le token.
        return $_SESSION['user']['token'];
    }
}