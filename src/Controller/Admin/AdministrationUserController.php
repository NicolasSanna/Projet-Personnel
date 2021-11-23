<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\UserModel;
use App\Model\GrantModel;

class AdministrationUserController extends AbstractController
{
    public function administrationUsers()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        $userModel = new UserModel();
        $usersInfos = $userModel->adminUsers();

        $pageTitle = 'Administrer les utiliateurs';

        return $this->render('admin/adminusers', [
            'usersInfos' => $usersInfos??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    function deleteUser()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {
            $idOfUser = $_GET['id'];

            $userModel = new UserModel();
            $userInfos = $userModel->getUserById($idOfUser);

            $pageTitle = 'Supprimer un utilisateur';

            if(!$userInfos)
            {
                FlashBag::addFlash("Cet utilisateur n'existe pas", 'error');
                $this->redirect('adminusers');
            }

            if (!empty($_POST))
            {
                $choice = (int) $_POST['deleteuser'];

                switch ($choice)
                {
                    case 1:
                    {
                        $userModel = new userModel();
                        $deleteUser = $userModel->deleteUser($idOfUser);
                        Flashbag::addFlash($deleteUser['message'], 'query');
                        break;
                    }
                    case 2:
                    {
                        $userModel = new UserModel();
                        $deleteUser = $userModel->deleteUserWithoutArticlesComments($idOfUser);
                        FlashBag::addFlash($deleteUser['message'], 'query');
                        break;
                    }
                    default:
                    {
                        $this->redirect('administration');
                    }
                }
            }
            
        }
        else
        {
            $this->redirect('administration');
        }

        return $this->render('admin/deleteUser', [
            'userInfos' => $userInfos??'',
            'pageTitle' => $pageTitle??''
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
        $pageTitle = 'Modifier les privilèges utilisateur';

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {
            $userId = $_GET['id'];
            $userModel = new UserModel();
            $userInfos = $userModel->getUserById($userId);

            if(!$userInfos)
            {
                FlashBag::addFlash("Cet utilisateur n'existe pas", 'error');
                $this->redirect('adminusers');
            }

            if(!empty($_POST))
            {
                $grantId = (int) $_POST['grants'];

                $userChangeGrantModel = new UserModel();
                $changeGrant = $userChangeGrantModel->changeGrant($userId, $grantId);
                FlashBag::addFlash($changeGrant['message'], 'query');
            }
        }
        else
        {
            $this->redirect('administration');
        }
        
        return $this->render('admin/modifygrantuser', [
            'grants' => $grants??'',
            'userInfos' => $userInfos??'',
            'pageTitle' => $pageTitle??''
        ]);
    }
}