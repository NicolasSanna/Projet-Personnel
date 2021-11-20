<?php

namespace App\Model;

use App\Framework\AbstractModel;

class CategoryModel extends AbstractModel
{
    public function getOneCategory(int $idOfCategory)
    {
        $sql = 'CALL SP_CategorySelect(?)';

        $category = $this->database->getOneResult($sql, [$idOfCategory]);

        return $category;
    }

    public function getAllCategories()
    {
        $sql = 'CALL SP_AllCategoriesSelect()';

        $categories = $this->database->getAllResults($sql);

        return $categories;
    }

    public function createCategory(string $newCategory)
    {
        $sql = 'CALL SP_CategoryInsert(?)';

        $insertNewCategory = $this->database->getOneResult($sql, [$newCategory]);

        return $insertNewCategory;
    }

    public function modifyCategory(int $idOfCategory, string $newCategoryName)
    {
        $sql =  'CALL SP_CategoryUpdate(?, ?)';

        $modifyCategory = $this->database->getOneResult($sql, [$idOfCategory, $newCategoryName]);

        return $modifyCategory;
    }

    public function getAllCategoriesForArticle()
    {
        $sql ='CALL SP_AllCategoriesForArticleSelect()';

        $allCategoriesForArticle = $this->database->getAllResults($sql);

        return $allCategoriesForArticle;
    }

    public function deleteCategory(int $idOfCategory)
    {
        $sql = 'CALL SP_CategoryDelete(?)';

        $deleteCategory = $this->database->getOneResult($sql, [$idOfCategory]);

        return $deleteCategory;
    }

    public function deleteCategoryWithoutArticles(int $idOfCategory)
    {
        $sql = 'CALL SP_CategoryWithoutArticlesDelete(?)';

        $deleteCategoryWithoutArticles = $this->database->getOneResult($sql, [$idOfCategory]);

        return $deleteCategoryWithoutArticles;
    }

    public function getAllCategoriesForForum()
    {
        $sql = 'CALL SP_AllCategoriesForArticleSelect()';

        $getAllCategoriesForForum = $this->database->getAllResults($sql);
        return $getAllCategoriesForForum;
    }

    public function getArticlesByCategory(int $idOfCategory)
    {
        $sql = 'CALL SP_ArticlesByCategorySelect(?)';

        $getArticlesByCategory = $this->database->getAllResults($sql, [$idOfCategory]);

        return $getArticlesByCategory;
    }
}