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
}