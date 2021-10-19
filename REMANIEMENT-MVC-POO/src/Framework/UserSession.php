<?php 

namespace App\Framework;

class UserSession 
{

    static private function sessionCheck()
    {
        if (session_status() === PHP_SESSION_NONE) 
        {
            session_start();
        }
    }

    /**
     * Enregistre les informations de l'utilisateur en session
     */
    static function register(int $userId, string $firstname, string $lastname, string $pseudo, string $email, int $grant_id)
    {
        self::sessionCheck();


        $_SESSION['user'] = [
            'userId' => $userId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudo' => $pseudo,
            'email' => $email,
            'grant_id' => $grant_id
        ];
    }



    static function isAuthenticated()
    {
        self::sessionCheck();
        return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
    }

    static function logout()
    {
        if (!self::isAuthenticated())
        {
            return;
        }
        $_SESSION['user'] = null;
        session_destroy();
    }

    static function getId()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['userId'];
    }

    static function getFirstname()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['firstname'];
    }

    static function getLastname()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['lastname'];
    }

    static function getEmail()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['email'];
    }
    
    static function administrator()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['grant_id'] == 1;
    }

    static function author()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['grant_id'] == 2;
    }


    static function newRegistered()
    {
        if (!self::isAuthenticated())
        {
            return null;
        }
        return $_SESSION['user']['grant_id'] == 3;
    }
}