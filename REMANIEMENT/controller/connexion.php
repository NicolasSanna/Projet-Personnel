<?php 

$template = 'connexion';
$pageTitle = 'Connexion';

if(isset($_POST['validate']))
{
    if (!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $sql = 'SELECT * 
                FROM users 
                WHERE email = LOWER(?)';
                
        $checkIfUserExists = executeQuery($sql, [$email]);
    
        if($checkIfUserExists->rowCount() > 0)
        {
            $usersInfos = getOneResult($sql, [$email]);

            if(password_verify($password, $usersInfos['password']))
            {
                if($usersInfos['grant_id'] == 1)
                {
                    $_SESSION['administrator'] = true;
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $usersInfos['id'];
                    $_SESSION['lastname'] = $usersInfos['lastname'];
                    $_SESSION['firstname'] = $usersInfos['firstname'];
                    $_SESSION['pseudo'] = $usersInfos['pseudo'];
                    $_SESSION['email'] = $usersInfos['email']; 
    
                    $_SESSION['success'] = "Identifiants validés. Bienvenue Administrateur !";
                    
                    header('Location:' . buildUrl('mesarticles'));
                }
                else
                {
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $usersInfos['id'];
                    $_SESSION['lastname'] = $usersInfos['lastname'];
                    $_SESSION['firstname'] = $usersInfos['firstname'];
                    $_SESSION['pseudo'] = $usersInfos['pseudo'];
                    $_SESSION['email'] = $usersInfos['email']; 
    
                    $_SESSION['success'] = "Identifiants validés. Bienvenue !";
                    
                    header('Location:' . buildUrl('mesarticles'));
                }
            }
            else
            {
                $_SESSION['error'] = "Votre mot de passe est incorrect.";
                header('Location:' . buildUrl('connexion'));
            }
        }
        else
        {
            $_SESSION['error'] = "Votre email est incorrect ou vous n'êtes pas inscrit.";
            header('Location:' . buildUrl('connexion'));
        }

    }
    else
    {
        $_SESSION['error'] = "Veuillez remplir tous les champs de connexion.";
        header('Location:' . buildUrl('connexion'));
    }
}

include TEMPLATE_DIR . '/base.phtml';