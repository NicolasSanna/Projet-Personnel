<?php

$template = 'inscription';
$pageTitle = 'Inscription';

if(isset($_POST['validate']))
{
    if(!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $lastname = trim(htmlspecialchars($_POST['lastname']));
        $firstname = trim(htmlspecialchars($_POST['firstname']));
        $pseudo = trim(htmlspecialchars($_POST['pseudo']));
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim(htmlspecialchars($_POST['password']));

        if(!$lastname || !$firstname || !$pseudo || !$email || !$password)
        {
            $_SESSION['error']= "Tous les champs n'ont pas été correctement remplis.";
            header('Location: ' . buildUrl('inscription'));
        }
        else
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {  
                $password = password_hash($password, PASSWORD_DEFAULT);

                $sql = 'CALL SP_Inscription(?, ?, ?, ?, ?)';

                $_SESSION['query'] = getOneResult($sql, [$firstname, $lastname, $pseudo, $email, $password]);

                header('Location: ' . buildUrl('inscription'));
            }
            else
            {
                $_SESSION['error'] = "Veuillez compléter correctement le formulaire afin de vous inscrire.";
                header('Location: ' . buildUrl('inscription'));
            }
        }

    }
    else
    {
        $_SESSION['error'] = "Tous les champs n'ont pas été correctement renseignés";
        header('Location: ' . buildUrl('inscription'));
    }

}

include TEMPLATE_DIR . '/base.phtml';