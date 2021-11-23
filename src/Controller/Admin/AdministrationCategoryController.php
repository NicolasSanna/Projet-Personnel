<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\CategoryModel;

class AdministrationCategoryController extends AbstractController
{
    public function addCategory()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        $pageTitle = 'Ajouter une catégorie';

        if(!empty($_POST))
        {
            
            $newCategory = trim($_POST['newcategory']);
            $token = $_POST['token'];

            if ($token != UserSession::token())
            {
                FlashBag::addFlash("MAUVAIS TOKEN !", 'error');
                $this->redirect('administration');
            }

            if(!$newCategory)
            {
                FlashBag::addFlash('Le champ est vide', 'error');
            }
            else
            {
                $categoryModel = new CategoryModel();
                $insertCategory = $categoryModel->createCategory($newCategory);
    
                FlashBag::addFlash($insertCategory['message'], 'query');
            }
        }


        return $this->render('admin/addCategory', [
            'newCategory' => $newCategory??''
        ]);
    }

    public function adminCategories()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
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
            $this->redirect('accessRefused');
        }

        $pageTitle = 'Modifier une catégorie';

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {
            $idOfCategory = $_GET['id'];
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getOneCategory($idOfCategory);

            if(!$category)
            {
                FlashBag::addFlash("Cette catégorie n'existe pas.", 'error');
                $this->redirect('administration');
            }

            if(!empty($_POST))
            {
                $idOfCategory = $_POST['idcategory'];
                $newcategory = trim($_POST['newcategory']);

                if(!$newcategory)
                {
                    FlashBag::addFlash("Le champ est vide.", 'error');
                }
                else
                {
                    $categoryModel = new CategoryModel();
                    $modifycategory = $categoryModel->modifyCategory($idOfCategory, $newcategory);
                    FlashBag::addFlash($modifycategory['message'], 'query');
                    $this->redirect('modifycategory', ['id' => $category['id']]);
                }
            }

        }
        else
        {
            $this->redirect('administration');
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
            $this->redirect('accessRefused');
        }

        $pageTitle = 'Supprimer une catégorie';

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {
            $idOfCategory = $_GET['id'];
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getOneCategory($idOfCategory);

            if(!$category)
            {
                FlashBag::addFlash("Cette catégorie n'existe pas.", 'error');
                $this->redirect('administration');
            }

            if (!empty($_POST))
            {
                $choiceDelete = (int) $_POST['deleteCategory'];

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
                        $this->redirect('administration');
                    }
                }
                $this->redirect('administration');
            }
        }
        else
        {
            $this->redirect('administration');
        }

        return $this->render('admin/deleteCategory', [
            'category' => $category??'',
            'pageTitle' => $pageTitle??''
        ]);

    }
}