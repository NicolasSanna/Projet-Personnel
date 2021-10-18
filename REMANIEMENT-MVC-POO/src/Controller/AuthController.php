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

                if ($user['grant_id'] == 1)
                {
                    FlashBag::addFlash('Connexion réussie, bienvenue Administrateur!', 'success');
                    UserSession::administrator();
                }
                elseif ($user['grant_id'] == 2)
                {
                    FlashBag::addFlash('Connexion réussie, bienvenue auteur !', 'success');
                    UserSession::author();
                }
                elseif ($user['grant_id'] == 3)
                {
                    FlashBag::addFlash('Connexion réussie, bienvenue nouvel utilisateur !', 'success');
                    UserSession::newRegistered();
                }
                $this->redirect('homepage');
                exit;
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