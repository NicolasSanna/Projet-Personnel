<?php

namespace App\Controller;

use App\Framework\Post;
use App\Model\UserModel;
use App\Framework\Mailing;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Framework\AbstractController;

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
                UserSession::register(
                    $user['id'], 
                    $user['firstname'], 
                    $user['lastname'], 
                    $user['pseudo'], 
                    $user['email'], 
                    $user['grant_id'], 
                    $user['grant_label']);
                    
                FlashBag::addFlash("Connexion réussie, bienvenue !", 'success');

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

    public function sendEmailForgetPassword()
    {
        if(!empty($_POST))
        {
            $email = Post::verifyContent('email');

            if(!$email)
            {
                FlashBag::addFlash('Le champ email est vide', 'error');
            }

            $userModel = new UserModel();
            $emailExists = $userModel->getUserByEmail($email);

            if(!$emailExists)
            {
                FlashBag::addFlash('Cet email n\'existe pas.', 'error');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }


            if(!(FlashBag::hasMessages('error')))
            {
                

                $keyReinitialization = bin2hex(openssl_random_pseudo_bytes(24));

                $userModel->keyReinitialization($email, $keyReinitialization);

                $bodyVar = [
                    'email' => $email,
                    'keyReinitialization' => $keyReinitialization
                ];

                $emailing = new Mailing();
                $emailing->sendEmailForgetPassword($bodyVar);

                FlashBag::addFlash('Votre demande de réinitialisation de mot de passe a bien été prise en compte. Vous allez recevoir un email afin de poursuivre la procédure.', 'success');
            }
        }
        return $this->render('sendEmailForgetPassword', [
            'email' => $email??''
        ]);
    }

    public function changePassword()
    {
        if(!empty($_POST))
        {
            $email = Post::verifyContent('email');
            $newPassword = Post::verifyContent('newPassword');
            $confirmNewPassword = Post::verifyContent('confirmNewPassword');

            if(!$email || !$newPassword || !$confirmNewPassword)
            {
                FlashBag::addFlash('Tous les champs n\'ont pas été remplis.', 'error');
            }

            $userModel = new UserModel();
            $emailExists = $userModel->getUserByEmail($email);

            if(!$emailExists)
            {
                FlashBag::addFlash('Cet email n\'existe pas.', 'error');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }

            if(!(FlashBag::hasMessages('error')))
            {
                FlashBag::addFlash('Youpi', 'success'); 
                dump($_POST);
            }

           

        }
        return $this->render('changePassword', [
            'email' => $email??''
        ]);
    }

}