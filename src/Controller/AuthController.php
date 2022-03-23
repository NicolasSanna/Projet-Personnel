<?php

namespace App\Controller;

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

                return $this->redirect('homepage');

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

        return $this->redirect('homepage');
        exit;
    }

    public function sendEmailForgetPassword()
    {
        
        $pageTitle = 'Réinitialiser le mot de passe';

        if(!empty($_POST))
        {
            $email =  trim($_POST['email']);

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

                FlashBag::addFlash("Votre demande de réinitialisation de mot de passe a bien été prise en compte. Vous allez recevoir la clé de réinitialisation par email. Pour continuer, cliquez sur 'changer le mot de passe'.", 'success');
            }
        }
        return $this->render('sendEmailForgetPassword', [
            'email' => $email??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function changePassword()
    {
        $pageTitle = 'Modifier le mot de passe';

        if(!empty($_POST))
        {
            $email =  trim($_POST['email']);
            $newPassword =  trim($_POST['newPassword']);
            $confirmNewPassword =  trim($_POST['confirmNewPassword']);
            $keyReinitialization =  trim($_POST['keyReinitialization']);

            if(!$email || !$newPassword || !$confirmNewPassword || !$keyReinitialization)
            {
                FlashBag::addFlash('Tous les champs n\'ont pas été remplis.', 'error');
            }

            $uppercase = preg_match('@[A-Z]@', $newPassword);
            $lowercase = preg_match('@[a-z]@', $newPassword);
            $number    = preg_match('@[0-9]@', $newPassword);
            $specialChars = preg_match('@[^\w]@', $newPassword);

            if(!$uppercase || !$lowercase || !$number || !$specialChars) 
            {
                FlashBag::addFlash("Le mot de passe doit contenir au moins une majuscule, une miniscule, un chiffre et un caractère spécial", 'error');
            }

            $userModel = new UserModel();
            $emailExists = $userModel->getUserByEmail($email);

            if(!$emailExists)
            {
                FlashBag::addFlash('Cet email n\'existe pas.', 'error');
            }

            if (strlen($newPassword) < 8)
            {
                FlashBag::addFlash("Le mot de passe doit contenir au moins 8 caractères.", 'error');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }

            if($newPassword != $confirmNewPassword)
            {
                FlashBag::addFlash('Le mot de passe et sa confirmation sont différents.', 'error'); 
            }

            if(str_contains($keyReinitialization, ' '))
            {
                FlashBag::addFlash('La clé de réinitialisation est incorrecte.', 'error');
            }

            if(!(FlashBag::hasMessages('error')))
            {
                
                $hash = password_hash($newPassword, PASSWORD_DEFAULT);
                $result = $userModel->changePassword($email, $hash, $keyReinitialization);
                FlashBag::addFlash($result['message'], 'query'); 
            }
        }
        return $this->render('changePassword', [
            'email' => $email??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

}