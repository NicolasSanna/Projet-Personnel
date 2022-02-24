<?php

/**
 * Déclaration de l'espace de nom (composer.json : src/Framework/Content.php)
 */
namespace App\Framework;

/**
 * Utilisation de la classe Server (composer.json : src/Framework/Server.php)
 */
use App\Framework\Server;

/**
 * Création de la classe Content
 */
class Content
{
    /**
     * Création d'une méthode statique publique verifyChars. Elle prend en paramètre le tableau associatif de données provenant du Controller avant de renvoyer les données au templates dans la méthode render de l'AbstractController.
     */
    public static function verifyChars(array $array): array
    {
        /**
         * On récupère le path de la page courante.
         */
        $path = Server::path();

        /**
         * On effectue une boucle de récupération du tableau associatif clé => valeur
         */
        foreach ($array as $key => $value)
        {
            /**
             * Si le path de la page courante est différent de /forum/article OU /administration/modifierarticle (puisque ce sont les deux SEULES pages où l'on autorise l'interpréation de balises HTML pour le rendu d'affichage) du TinyMCE...
             */
            if ($path != '/forum/article' || $path != '/administration/modifierarticle')
            {
                /**
                 * Si la valeur est un tableau (retour de boucle de données) alors on rappelle la même méthode et l'on transforme les caractères spéciaux en entités HTML que le navigateur ne doit pas interpréter. Et l'on range cela dans la clé du tableau associatif.
                 */
                $array[$key] = is_array($value) ?  self::verifyChars($value) : htmlspecialchars($value);
            }
        }

        /**
         * On renvoie l'ensemble des données du tableau à l'AbstractController.
         */
        return $array;
    }
}