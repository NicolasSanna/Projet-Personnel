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
         * On créé un tableau dans lequel on indique les paths qui autorisent l'interprétation des balises HTML.
         */
        $pathAutorized = ['/forum/article', '/administration/modifierarticle', '/administration/creerunarticle'];

        /**
         * Si le path recherché n'est pas présent dans le tableau des paths autorisés à interpréter les balises HTML...
         */
        if (!in_array($path, $pathAutorized))
        {
            /**
             * On effectue une boucle de récupération du tableau associatif clé => valeur
             */
            foreach ($array as $key => $value)
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