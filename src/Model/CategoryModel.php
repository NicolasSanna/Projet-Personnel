<?php

// Espace de nom App\Model (composer.json : src/Model)
namespace App\Model;

// On va chercher App\Framework\AbstractModel (composer.json : src/Framework/AbstractModel).
use App\Framework\AbstractModel;

// On créé la classe Category Model qui hérite grâce à extends des propriétés et des méthodes de l'Abstract Model. (Celle-ci créé l'objet Database auquel nous avons accès ici).
class CategoryModel extends AbstractModel
{
    // Création de la méthode getOneCategory qui prend en paramètre l'identifiant nunmérique de la catégorie recherchée.
    public function getOneCategory(int $idOfCategory)
    {
        // On créé une variable $sql qui appelle la procédure stockée en lui donnant le paramètre anonyme pour la préparation de la requête.
        $sql = 'CALL SP_CategorySelect(?)';

        // On récupère dans la varaible $category l'opération à partir de la méthode getOneCategory de l'objet database.
        $category = $this->database->getOneResult($sql, [$idOfCategory]);

        /// On retourne $category.
        return $category;
    }

    // On créé une méthode getAllCategories(). Sauf la catégorie Non classée afin de ne pas la supprimer.
    public function getAllCategories()
    {
        // On stocke dans la variable $sql l'appel à la procédure stockée correspondante.
        $sql = 'CALL SP_AllCategoriesSelect()';

        // On récupère dans $categories l'exécution de l'opération depuis l'objet database et sa méthode getAllResults. On lui donne ne paramètre la requête SQL.
        $categories = $this->database->getAllResults($sql);

        // On retourne le résultat dans $categories.
        return $categories;
    }

    // On créé une méthode createCategory qui prend en paramètre une chaîne de caractères. C'est cette méthode que l'on appelle pour créer une nouvelle catégorie.
    public function createCategory(string $newCategory)
    {
        // On stocke dans $sql l'appel de notre procédure stockée.
        $sql = 'CALL SP_CategoryInsert(?)';

        // ON stocke dans insertNewcCategory le résultat de l'opération depuis la base de données.
        $insertNewCategory = $this->database->getOneResult($sql, [$newCategory]);

        // On retourne le résultat de $insertNewCategory. (le résultat du message de la procédure stockée notamment).
        return $insertNewCategory;
    }

    // On créé une fonction modifyCategory qui prend en paramètre le numéro d'identifiant de la table categories et la chaîne de caractère qui va remplacer l'ancien nom de la catégorie concernée.
    public function modifyCategory(int $idOfCategory, string $newCategoryName)
    {
        // On créé une variable $sql qui va être la requête SQL. Elle appelle la procédure stockée.
        $sql =  'CALL SP_CategoryUpdate(?, ?)';

        // On stocke dans $modifyCategory le résultat de l'opération dans l'objet database et sa méthode getOneResult. on lui donne les paramètres à la suite de la requête SQL à réaliser. 
        $modifyCategory = $this->database->getOneResult($sql, [$idOfCategory, $newCategoryName]);

        // On retourne la variable $modifyCategory.
        return $modifyCategory;
    }
    
    // On créé une méthode getAllCategoriesForArticle(). Elle contient toutes les catégories. 
    public function getAllCategoriesForArticle()
    {
        // On stocke dans $sql la requête SQL. La procédure stockée ici.
        $sql ='CALL SP_AllCategoriesForArticleSelect()';

        // On récupère dans $allCategoriesForArticle le résultat de la méthode getAllResults et de la requête SQL dans l'objet database.
        $allCategoriesForArticle = $this->database->getAllResults($sql);

        // On renvoie le résultat final.
        return $allCategoriesForArticle;
    }

    // On créé une méthode deleteCategory qui prend en paramètre le numéro d'identifiant de la table categories.
    public function deleteCategory(int $idOfCategory)
    {
        // On stocke dans $sql l'appel de la procédure stockée.
        $sql = 'CALL SP_CategoryDelete(?)';

        // On stocke dans $deleteCategory le résultat de la méthode getOneResult de l'objet database.
        $deleteCategory = $this->database->getOneResult($sql, [$idOfCategory]);

        // On renvoie le résultat.
        return $deleteCategory;
    }

    // On créé une fonctionn deleteCategoryWithoutArticles. Elle prend en paramètre le numéro de la catégorie.
    public function deleteCategoryWithoutArticles(int $idOfCategory)
    {
        // On stocke dans $sql l'appel de la procédure stockée en lui donnant le paramètre anonyme.
        $sql = 'CALL SP_CategoryWithoutArticlesDelete(?)';

        // On range dans $deleteCategoryWithoutArticles le résultat de la méthode getOneResult avec $sql et l'identifiant en paramètre à supprimer.
        $deleteCategoryWithoutArticles = $this->database->getOneResult($sql, [$idOfCategory]);

        // On retourne le résultat.
        return $deleteCategoryWithoutArticles;
    }

    // On créé une méthode getAllCategoriesForForum().
    public function getAllCategoriesForForum()
    {
        // On stocke dans $sql l'appel de la procédure stockée.
        $sql = 'CALL SP_AllCategoriesForArticleSelect()';

        // On récupère dans la variable le résultat de la requête sql depuis la méthode getAllResult de l'objet database.
        $getAllCategoriesForForum = $this->database->getAllResults($sql);

        // On retourne le résultat.
        return $getAllCategoriesForForum;
    }

    // On créé une méthode getArticlesByCategory en prenant en paramètre le numéro d'identifiant de la catégorie concernée. 
    public function getArticlesByCategory(int $idOfCategory)
    {
        // On stocke dans $sql la requête SQL à effectuer. Ici, l'appel d'une procédure stockée avec un paramètre anonyme.
        $sql = 'CALL SP_ArticlesByCategorySelect(?)';

        // On stocke le résultat de la méthode getAllResults et de ses paramètre venant de l'objet database dans une variable.
        $getArticlesByCategory = $this->database->getAllResults($sql, [$idOfCategory]);

        // On retourne le résultat.
        return $getArticlesByCategory;
    }
}