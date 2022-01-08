<?php

namespace App\Framework;

class Get 
{
    /**
     * On créé une fonction existsDigit qui prend en paramètre la clé du tableau associatif de $_GET[$key].
     */
    static function existsDigit(string $key)
    {
        /**
         * Si une clé existe dans l'URL, et que cette clé est déclarée dans l'URL et qu'elle est de type numérique.
         */
        if (array_key_exists($key, $_GET) && $_GET[$key] && ctype_digit($_GET[$key]))
        {
            /**
             * On retourne true, ce qui signifie que l'on pourra entrer dans la condition.
             */
            return true;
        }
    }

    /**
     * Création de la fonction statique key, elle permet de contrôller qu'un paramètre donné en GET n'est pas interprété.
     */
    static function key(string $key)
    {
        $get = htmlspecialchars($_GET[$key]);
        return $get;
    }
}