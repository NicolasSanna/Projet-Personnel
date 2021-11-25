<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Model\UserModel;

class AccountController extends AbstractController
{
    public function signup()
    {
        $pageTitle = 'Inscription';

        if(!empty($_POST))
        {
            $lastname = trim(htmlspecialchars($_POST['lastname']));
            $firstname = trim(htmlspecialchars($_POST['firstname']));
            $pseudo = trim(htmlspecialchars($_POST['pseudo']));
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim(htmlspecialchars($_POST['password']));
            $confirmPassword = trim(htmlspecialchars($_POST['confirmPassword']));

            if (!$lastname || !$firstname || !$pseudo || !$email || !$password || !$confirmPassword)
            {
                FlashBag::addFlash("Tous les champs d'inscription n'ont pas été correctement remplis", 'error');
            }


            if (strlen($password) < 8)
            {
                FlashBag::addFlash("Le mot de passe doit contenir au moins 8 caractères.", 'error');
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                FlashBag::addFlash('Vérifiez le format de votre email.', 'error'); 
            }

            if($password != $confirmPassword)
            {
                FlashBag::addFlash("Le mot de passe confirmé ne correspond pas à celui que vous voulez utiliser.", 'error');
            }

            if (!(FlashBag::hasMessages('error')))
            {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $newUser = new UserModel();
                $insertUser = $newUser->createUser($firstname, $lastname, $pseudo, $email, $hash);

                FlashBag::addFlash($insertUser['message'], 'query');
            }
        }
        return $this->render('inscription', [
            'lastname' => $lastname??'',
            'firstname' => $firstname??'',
            'pseudo' => $pseudo??'',
            'email' => $email??'',
            'pageTitle' => $pageTitle??''
        ]);
    }
}