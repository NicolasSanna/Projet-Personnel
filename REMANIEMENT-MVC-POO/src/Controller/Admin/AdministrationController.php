<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Model\CategoryModel;
use App\Model\ArticleModel;
use App\Framework\UserSession;
use App\Model\UserModel;

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
            $checkIfUserExists = $userModel->getUserById($idOfUser);

            if(!$checkIfUserExists)
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
        return $this->render('admin/deleteUser');
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

            $categoryModel = new CategoryModel();
            $insertCategory = $categoryModel->createCategory($newCategory);

            FlashBag::addFlash($insertCategory['message']);
        }


        return $this->render('admin/addCategory', [
            'newCategory' => $newCategory??''
        ]);
    }

    public function adminCategories()
    {

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();
        return $this->render('admin/admincategory');
    }
}