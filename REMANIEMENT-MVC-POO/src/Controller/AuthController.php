<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\UserModel;
use App\Framework\UserSession;
use App\Framework\FlashBag;

class AuthController extends AbstractController
{
    public function login()
    {
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
            'email' => $email??''
        ]);
    }

    public function logout()
    {
        UserSession::logout();

        $this->redirect('homepage');
        exit;
    }
}