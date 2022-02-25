<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Framework\Mailing;
use App\Framework\FlashBag;
use App\Framework\AbstractController;

class AccountController extends AbstractController
{
    public function signup()
    {
        $pageTitle = 'Inscription';

        if(!empty($_POST))
        {
            $lastname = trim($_POST['lastname']);
            $firstname = trim($_POST['firstname']);
            $pseudo = trim($_POST['pseudo']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirmPassword']);
            $recaptchaResponse = trim($_POST['recaptcha-response']);

            if (!$lastname || !$firstname || !$pseudo || !$email || !$password || !$confirmPassword || !$recaptchaResponse)
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

            $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LeH3ZYdAAAAAA8Dl0tIO-mqBLW32JoqD65FDS2D&response={$recaptchaResponse}";
            $response = file_get_contents($url);

            // On vérifie qu'on a une réponse
            if(empty($response) || is_null($response))
            {
                FlashBag::addFlash('Erreur à l\'inscription', 'error');
            }

            $data = json_decode($response);

            if(!$data->success)
            {
                FlashBag::addFlash('Erreur à l\'inscription', 'error');
            }

            if (!(FlashBag::hasMessages('error')))
            {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $newUser = new UserModel();
                $insertUser = $newUser->createUser($firstname, $lastname, $pseudo, $email, $hash);

                $bodyVar = [
                    'email' => $email
                ];

                FlashBag::addFlash($insertUser['message'], 'query');

                if ($insertUser['message'] == "Vous êtes bien enregistré, vous pouvez vous connecter.")
                {
                    $emailing = new Mailing();
                    $emailing->sendEmailtoAdmin($bodyVar);
                }
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