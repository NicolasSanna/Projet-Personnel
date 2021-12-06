<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\UserSession;
use App\Framework\FlashBag;
use App\Model\UserModel;


class AuthController extends AbstractController
{
    public function login()
    {
        $pageTitle = 'Connexion';

        if (!empty($_POST))
        {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->checkCredentials($email, $password);

            if (!$user)
            {
                FlashBag::addFlash('Identifiants incorrects', 'error');
            }
            else
            {
                UserSession::register($user['id'], $user['firstname'], $user['lastname'], $user['pseudo'], $user['email'], $user['grant_id']);

                switch ($user['grant_id'])
                {
                    case 1:
                    {
                        FlashBag::addFlash('Connexion réussie, bienvenue Administrateur!', 'success');
                        UserSession::administrator();
                        break;
                    }
                    case 2:
                    {
                        FlashBag::addFlash('Connexion réussie, bienvenue auteur !', 'success');
                        UserSession::author();
                        break;
                    }
                    case 3:
                    {
                        FlashBag::addFlash('Connexion réussie, bienvenue nouvel utilisateur !', 'success');
                        UserSession::newRegistered();
                        break;
                    }
                    default:
                    {
                        UserSession::newRegistered();
                    }
                }


                $this->redirect('homepage');

            }

        }
        return $this->render('login', [
            'email' => $email??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function logout()
    {
        UserSession::logout();

        $this->redirect('homepage');
        exit;
    }

    // public function changePassword()
    // {
    //     $pageTitle = 'Modifier le mot de passe';

    //     if (!empty($_POST))
    //     {
    //         $email = trim(htmlspecialchars($_POST['email']));
    //         $newPassword = trim(htmlspecialchars($_POST['newPassword']));
    //         $confirmNewPassword = trim(htmlspecialchars($_POST ['confirmNewPassword']));

    //         if (!$email || !$newPassword || !$confirmNewPassword)
    //         {
    //             FlashBag::addFlash("Tous les champs de modification n'ont pas été correctement remplis", 'error');
    //         }
            
    //         if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    //         {
    //             FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
    //         }

    //         if (strlen($newPassword) < 8)
    //         {
    //             FlashBag::addFlash("Le mot de passe doit contenir au moins 8 caractères.", 'error');
    //         }

    //         if($newPassword != $confirmNewPassword)
    //         {
    //             FlashBag::addFlash("Le mot de passe confirmé ne correspond pas à celui que vous voulez utiliser.", 'error');
    //         }

    //         if (!(FlashBag::hasMessages('error')))
    //         {
    //             $hash = password_hash($newPassword , PASSWORD_DEFAULT);
    //             $userModel = new UserModel();
    //             $modifyPassword = $userModel->changePassword($email, $hash);

    //             FlashBag::addFlash($modifyPassword['message'], 'query');
    //             $this->redirect('connexion');
    //         }

    //     }

    //     return $this->render('modifyPassword', [
    //         'pageTitle' => $pageTitle??'',
    //         'email' => $email??''
    //     ]);
    // }
}