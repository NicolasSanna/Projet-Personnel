<?php

namespace App\Controller\Admin;

use App\Framework\Get;
use App\Framework\Post;
use App\Model\UserModel;
use App\Model\GrantModel;
use App\Framework\Mailing;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class AdministrationUserController extends AbstractController
{
    public function administrationUsers()
    {
        // if(!UserSession::administrator())
        // {
        //     return $this->redirect('accessRefused');
        // }

        $userModel = new UserModel();
        $usersInfos = $userModel->adminUsers();

        $pageTitle = 'Administrer les utiliateurs';

        return $this->render('admin/adminUsers', [
            'usersInfos' => $usersInfos??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    function deleteUser()
    {
        if(!UserSession::administrator())
        {
            return $this->redirect('accessRefused');
        }

        if (Get::existsDigit('id'))
        {
            $idOfUser = Get::key('id');

            $userModel = new UserModel();
            $userInfos = $userModel->getUserById($idOfUser);

            $pageTitle = 'Supprimer un utilisateur';

            if(!$userInfos)
            {
                FlashBag::addFlash("Cet utilisateur n'existe pas", 'error');
                return $this->redirect('adminusers');
            }

            if (!empty($_POST))
            {
                $choice = (int) $_POST['deleteuser'];
                $token = $_POST['token'];

                if($token != UserSession::token())
                {
                    FlashBag::addFlash("Une erreur s'est produite lors de la suppression.", 'error');
                    return $this->redirect('adminusers');
                }

                if (!(FlashBag::hasMessages('error')))
                {
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
                            return $this->redirect('administration');
                        }
                    }
                }
                return $this->redirect('adminusers');    
            }
        }
        else
        {
            return $this->redirect('administration');
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

        if (Get::existsDigit('id'))
        {
            $userId = Get::key('id');
            $userModel = new UserModel();
            $userInfos = $userModel->getUserById($userId);

            if(!$userInfos)
            {
                FlashBag::addFlash("Cet utilisateur n'existe pas", 'error');
                return $this->redirect('adminusers');
            }

            if(!empty($_POST))
            {
                $grantId = (int) $_POST['grants'];

                $userChangeGrantModel = new UserModel();
                $changeGrant = $userChangeGrantModel->changeGrant($userId, $grantId);

                $bodyVar = [
                    'email' => $userInfos['email']
                ];

                $emailng = new Mailing();
                $emailng->sendEmailChangeGrants($bodyVar);


                FlashBag::addFlash($changeGrant['message'], 'query');
                return $this->redirect('adminUsers');
            }
        }
        else
        {
            return $this->redirect('administration');
        }
        
        return $this->render('admin/modifyGrantUser', [
            'grants' => $grants??'',
            'userInfos' => $userInfos??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function modifyInfosUser()
    { 

        if (UserSession::isAuthenticated())
        {
            $pageTitle = 'Modifier mes informations personnelles';

            $firstname = UserSession::getFirstname();
            $lastname = UserSession::getLastname();
            $email = UserSession::getEmail();
            $pseudo = UserSession::getPseudo();
            $id_user = UserSession::getId();

            if(!empty($_POST))
            {
                $lastnameUpdate =  trim($_POST['lastname']);
                $firstnameUpdate =  trim($_POST['firstname']);
                $pseudoUpdate =  trim($_POST['pseudo']);
                $emailUpdate =  trim($_POST['email']);
                $token = $_POST['token'];

                if ($token != UserSession::token())
                {
                    FlashBag::addFlash("Une erreur est survenue à la mise à jours des informations personnels", 'error');
                }

                if (!$lastnameUpdate || !$firstnameUpdate || !$pseudoUpdate || !$emailUpdate)
                {
                    FlashBag::addFlash("Tous les champs de modification n'ont pas été correctement remplis", 'error');
                }
    
                if(!filter_var($emailUpdate, FILTER_VALIDATE_EMAIL))
                {
                    FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
                }
    
                if(!FlashBag::hasMessages('error'))
                {
                        $userModel = new UserModel();
                        $updateUser = $userModel->updateInfosPersosUser($firstnameUpdate, $lastnameUpdate, $pseudoUpdate, $emailUpdate, $id_user);
                        FlashBag::addFlash($updateUser['message'], 'query');
                }

            }
        }
        else
        {
            return $this->redirect('accessRefused');
        }
        

        return $this->render('admin/infospersos', [

                'firstname' => $firstnameUpdate??$firstname,
                'lastname' => $lastnameUpdate??$lastname,
                'pseudo' => $pseudoUpdate??$pseudo,
                'email' => $emailUpdate??$email,
            'pageTitle' => $pageTitle
        ]);
    }
}