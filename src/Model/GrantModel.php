<?php

// On indique l'espace de nom. Ici App\Model (composer.json : src/Model).
namespace App\Model;

// On indique que l'on se sert de la class AbstractModel.
use App\Framework\AbstractModel;

/**
 * On créé la classe GrantModel, elle hérite de l'AbstractModel et des propriétés de Database lors de son instanciation dans ce fichier AbstractModel.php.
 */
class GrantModel extends AbstractModel
{
    // On créé une fcontion getAllGrants.
    function getAllGrants()
    {
        // On range dans $sql l'appel de la procédure stockée.
        $sql = 'CALL SP_AllGrantsSelect ()';

        // On range dans $allGrants le résultat de l'appel de la procédure stockée.
        $allGrants = $this->database->getAllResults($sql);

        // On retourne le résultat 
        return $allGrants;
    }
}