<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Model\CategoryModel;
use App\Model\ArticleModel;
use App\Framework\UserSession;
use App\Model\UserModel;
use App\Model\GrantModel;

class AdministrationController extends AbstractController
{

    public function index()
    {
        if(!UserSession::isAuthenticated())
        {
            $this->redirect('accessRefused');
        }

        return $this->render('admin/administration');
    }

    public function administrationUsers()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        $userModel = new UserModel();
        $usersInfos = $userModel->adminUsers();

        return $this->render('admin/adminusers', [
            'usersInfos' => $usersInfos??''
        ]);
    }

    function deleteUser()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id']))
        {
            $idOfUser = $_GET['id'];

            $userModel = new UserModel();
            $userInfos = $userModel->getUserById($idOfUser);

            if(!$userInfos)
            {
                FlashBag::addFlash("Cet utilisateur n'existe pas", 'error');
                $this->redirect('adminusers');
            }

            if (!empty($_POST))
            {
                $choice = $_POST['deleteuser'];

                if($choice == 1)
                {
                    $userModel = new userModel();
                    $deleteUser = $userModel->deleteUser($idOfUser);
                    Flashbag::addFlash($deleteUser['message']);
                }
                elseif ($choice == 2)
                {
                    $userModel = new UserModel();
                    $deleteUser = $userModel->deleteUserWithoutArticlesComments($idOfUser);
                    FlashBag::addFlash($deleteUser['message']);
                }
            }
            
        }
        return $this->render('admin/deleteUser', [
            'userInfos' => $userInfos
        ]);
    }

    public function addCategory()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if(!empty($_POST))
        {
            $newCategory = trim($_POST['newcategory']);

            if(!$newCategory)
            {
                FlashBag::addFlash('Le champ est vide', 'error');
            }
            else
            {
                $categoryModel = new CategoryModel();
                $insertCategory = $categoryModel->createCategory($newCategory);
    
                FlashBag::addFlash($insertCategory['message']);
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

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        return $this->render('admin/admincategory', [
            'categories' => $categories
        ]);
    }

    public function modifyGrantUser()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        $grantModel = new GrantModel();
        $grants = $grantModel->getAllGrants();


        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id']))
        {
                $userId = $_GET['id'];
                $userModel = new UserModel();
                $checkIfUserExists = $userModel->getUserById($userId);

                if(!$checkIfUserExists)
                {
                    FlashBag::addFlash("Cet utilisateur n'existe pas", 'error');
                    $this->redirect('adminusers');
                }

                if(!empty($_POST))
                {
                    $grantId = (int) $_POST['grants'];

                    $userChangeGrantModel = new UserModel();
                    $changeGrant = $userChangeGrantModel->changeGrant($userId, $grantId);
                    FlashBag::addFlash($changeGrant['message']);
                }
        }
        
        return $this->render('admin/modifygrantuser', [
            'grants' => $grants
        ]);
    }

    public function modifyCategory()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id']))
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
                    FlashBag::addFlash($modifycategory['message']);
                    $this->redirect('modifycategory', ['id' => $category['id']]);

                }
            }

        }

        return $this->render('admin/modifycategory', [
            'category' => $category??'',
            'newcategory' => $newcategory??''
        ]);
    }

    public function deleteCategory()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id']))
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

                if ($choiceDelete == 1)
                {
                    $categoryModel = new CategoryModel();
                    $deleteCategory = $categoryModel->deleteCategory($idOfCategory);
                    FlashBag::addFlash($deleteCategory['message']);
                    
                }
                elseif ($choiceDelete == 2)
                {
                    $deleteCategory = $categoryModel->deleteCategoryWithoutArticles($idOfCategory);
                    FlashBag::addFlash($deleteCategory['message']);
                    
                }
                $this->redirect('administration');
            }

        }

        return $this->render('admin/deleteCategory', [
            'category' => $category
        ]);

    }
}