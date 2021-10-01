<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\UserModel;

class AccountController extends AbstractController
{
    public function signup()
    {

        if(!empty($_POST))
        {
            $lastname = trim(htmlspecialchars($_POST['lastname']));
            $firstname = trim(htmlspecialchars($_POST['firstname']));
            $pseudo = trim(htmlspecialchars($_POST['pseudo']));
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim(htmlspecialchars($_POST['password']));

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $newUser = new UserModel();
            $insertUser = $newUser->createUser($lastname, $firstname, $pseudo, $email, $hash);
            return $insertUser['message'];

        }
        return $this->render('inscription', [
            'lastname' => $lastname??'',
            'firstname' => $firstname??'',
            'pseudo' => $pseudo??'',
            'email' => $email??''
        ]);

    }
}