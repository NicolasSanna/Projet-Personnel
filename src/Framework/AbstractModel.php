<?php 

// On indique l'espace de nom : App\Framework (composer.json : src/Framework de l'autoload)
namespace App\Framework;

/**
 * Création de la classe abstraite AbstractModel.
 */
abstract class AbstractModel 
{
    // On créé un objet $database en privé (par conséquent inaccessible en dehors de cette classe ou de celles qui sont autorisées à l'appeller par le biais de extends);
    protected $database;

    /**
     * On créé la méthode publique construct qui ne prend aucun paramètre. 
     */
    public function __construct()
    {
        // On instancie l'objet Database dans this->database. 
        // Inutile de mettre un use /Database car le fichier Database.php est au même niveau que le fichier AbstractModel.php.
        $this->database = new Database();
    }
}