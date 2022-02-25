<?php

namespace App\Controller\Admin;

use App\Framework\Get;
use App\Framework\FlashBag;
use App\Model\CategoryModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class AdministrationCategoryController extends AbstractController
{
    public function addCategory()
    {
        if(!UserSession::administrator())
        {
            return $this->redirect('accessRefused');
        }

        $pageTitle = 'Ajouter une catégorie';

        if(!empty($_POST))
        {
            
            $newCategory = trim($_POST['newcategory']);
            $token = $_POST['token'];

            if ($token != UserSession::token())
            {
                FlashBag::addFlash("Une erreur s'est produite.", 'error');
                return $this->redirect('administration');
            }

            if(!$newCategory)
            {
                FlashBag::addFlash('Le champ est vide', 'error');
            }


            if (!(FlashBag::hasMessages('error')))
            {
                $categoryModel = new CategoryModel();
                $insertCategory = $categoryModel->createCategory($newCategory);
    
                FlashBag::addFlash($insertCategory['message'], 'query');
                return $this->redirect('adminCategories');
            }
        }
        return $this->render('admin/addCategory', [
            'newCategory' => $newCategory??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function adminCategories()
    {
        if(!UserSession::administrator())
        {
            return $this->redirect('accessRefused');
        }

        $pageTitle ='Administrer les catégories';

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        return $this->render('admin/admincategory', [
            'categories' => $categories??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function modifyCategory()
    {
        if(!UserSession::administrator())
        {
            return $this->redirect('accessRefused');
        }

        $pageTitle = 'Modifier une catégorie';

        if (Get::existsDigit('id'))
        {
            $idOfCategory = Get::key('id');
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getOneCategory($idOfCategory);

            if(!$category)
            {
                FlashBag::addFlash("Cette catégorie n'existe pas.", 'error');
                return $this->redirect('administration');
            }

            if(!empty($_POST))
            {
                $idOfCategory = $_POST['idcategory'];
                $newcategory = trim($_POST['newcategory']);

                if(!$newcategory)
                {
                    FlashBag::addFlash("Le champ est vide.", 'error');
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    $categoryModel = new CategoryModel();
                    $modifycategory = $categoryModel->modifyCategory($idOfCategory, $newcategory);
                    FlashBag::addFlash($modifycategory['message'], 'query');
                    $this->redirect('adminCategories');
                }
            }
        }
        else
        {
            return $this->redirect('administration');
        }

        return $this->render('admin/modifycategory', [
            'category' => $category??'',
            'newcategory' => $newcategory??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function deleteCategory()
    {
        if(!UserSession::administrator())
        {
            return $this->redirect('accessRefused');
        }

        $pageTitle = 'Supprimer une catégorie';

        if (Get::existsDigit('id'))
        {
            $idOfCategory = Get::key('id');
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getOneCategory($idOfCategory);

            if(!$category)
            {
                FlashBag::addFlash("Cette catégorie n'existe pas.", 'error');
                return $this->redirect('adminCategories');
            }

            if (!empty($_POST))
            {
                $choiceDelete = (int) $_POST['deleteCategory'];
                $token = $_POST['token'];

                if ($token != UserSession::token())
                {
                    FlashBag::addFlash("Une erreur s'est produite.", 'error');
                    return $this->redirect('adminCategories');
                }

                switch ($choiceDelete)
                {
                    case 1:
                    {
                        $categoryModel = new CategoryModel();
                        $deleteCategory = $categoryModel->deleteCategory($idOfCategory);
                        FlashBag::addFlash($deleteCategory['message'], 'query');
                        break;
                    }
                    case 2:
                    {
                        $deleteCategory = $categoryModel->deleteCategoryWithoutArticles($idOfCategory);
                        FlashBag::addFlash($deleteCategory['message'], 'query');
                        break;
                    }
                    default:
                    {
                        return $this->redirect('adminCategories');
                    }
                }
                return $this->redirect('adminCategories');
            }
        }
        else
        {
            return $this->redirect('adminCategories');
        }

        return $this->render('admin/deleteCategory', [
            'category' => $category??'',
            'pageTitle' => $pageTitle??''
        ]);

    }
}