<?php

namespace App\Framework;

class Post
{
    /**
     * On créé une fonction statique verifyContent qui prend en paramètre la clé du tableau associatif reçu de $_POST[$key].
     */
    static function verifyContent(string $key)
    {
        /**
         * On retire les caractères vides et on remplace les balises HTML par des caractères qui n'interprêtent pas le code HTML.
         */
        $content = trim(htmlspecialchars($_POST[$key]));

        /**
         * On renvoie le traitement terminé.
         */
        return $content;
    }
}