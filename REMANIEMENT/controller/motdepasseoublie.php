<?php

$pageTitle = 'Mot de passe oublié';
$template = 'motdepasseoublie';

if(isset($_POST['validate']))
{
    if (!empty($_POST['email']) && !empty($_POST['newpassword']))
    {
        $email = trim(htmlspecialchars($_POST['email']));
        $newpassword = trim($_POST['newpassword']);

        if (!$email || !$newpassword)
        {

            $_SESSION['error'] = "Tous les champs n'ont pas été correctement remplis.";
            header('Location: ' . buildUrl('motdepasseoublie'));
        }
        else
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);

                $sql = 'CALL SP_ModifyPassword(?, ?);';
    
                $_SESSION['query'] = getOneResult($sql, [$email, $newpassword ]);
    
                header('Location: ' . buildUrl('motdepasseoublie'));
            }
            else
            {
                $_SESSION['error'] = "Le format d'email est incorrect.";
                header('Location: ' . buildUrl('motdepasseoublie'));
            }
        }
    }
    else
    {
        $_SESSION['error'] = "Tous les champs n'ont pas été correctement remplis.";
        header('Location: ' . buildUrl('motdepasseoublie'));
    }
}


include TEMPLATE_DIR . '/base.phtml';