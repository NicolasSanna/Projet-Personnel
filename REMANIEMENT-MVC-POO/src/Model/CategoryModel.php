<?php

namespace App\Model;

use App\Framework\AbstractModel;

class CategoryModel extends AbstractModel
{
    public function getOneCategory($idOfCategory)
    {
        $sql = 'CALL SP_CategoryRead(?)';

        $category = $this->database->getOneResult($sql, [$idOfCategory]);

        return $category;
    }

    public function getAllCategories()
    {
        $sql = 'CALL SP_SelectAllCategories()';

        $categories = $this->database->getAllResults($sql);

        return $categories;
    }

    public function createCategory($newCategory)
    {
        $sql = 'CALL SP_CategoryCreate(?)';

        $insertNewCategory = $this->database->getOneResult($sql, [$newCategory]);

        return $insertNewCategory;
    }

    public function modifyCategory(int $idOfCategory, string $newCategoryName)
    {
        $sql =  'CALL SP_CategoryModify(?, ?)';

        $modifyCategory = $this->database->getOneResult($sql, [$idOfCategory, $newCategoryName]);

        return $modifyCategory;
    }

    public function getAllCategoriesForArticle()
    {
        $sql ='CALL SP_GetAllCategoriesForArticle()';

        $allCategoriesForArticle = $this->database->getAllResults($sql);

        return $allCategoriesForArticle;
    }

    public function deleteCategory($idOfCategory)
    {
        $sql = 'CALL SP_CategoryDelete(?)';

        $deleteCategory = $this->database->getOneResult($sql, [$idOfCategory]);

        return $deleteCategory;
    }

    public function deleteCategoryWithoutArticles($idOfCategory)
    {
        $sql = 'CALL SP_DeleteCategoryWithoutArticles(?)';

        $deleteCategoryWithoutArticles = $this->database->getOneResult($sql, [$idOfCategory]);

        return $deleteCategoryWithoutArticles;
    }

    
}