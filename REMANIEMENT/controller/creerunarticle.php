<?php

require CONTROLLER_DIR . '/security.php';

$pageTitle = 'Créer un article';
$template = 'creerunarticle';

$sql = 'SELECT * 
        FROM categories';
$categories = executeQuery($sql);

if(isset($_POST['validate']))
{
    if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['category']))
    {
        $title = trim(htmlspecialchars($_POST['title']));
        $content = trim(nl2br(htmlspecialchars($_POST['content'])));
        $category = (int) $_POST['category'];
        $id_user = $_SESSION['id'];

        if(!$title)
        {
            $_SESSION['error'] = "Le titre est vide.";
            header ('Location:' . buildUrl('creerunarticle'));
        }
        if(!$content)
        {
            $_SESSION['error'] = "Le contenu est vide.";
            header ('Location:' . buildUrl('creerunarticle'));
        }
        else
        {
            $sql = 'INSERT INTO articles (title, content, category_id, user_id, creation_date) 
                    VALUES (?, ?, ?, ?, NOW());';

            $insertArticleOnWebSite = executeQuery($sql, [$title, $content, $category, $id_user]);

            $_SESSION['success'] = "Votre article a bien été publié !";
            header ('Location:' . buildUrl('creerunarticle'));
        }

    }
    else
    {
        $_SESSION['error'] = "Tous les champs ne sont pas correctement remplis.";
        header ('Location:' . buildUrl('creerunarticle'));
    }
}

include TEMPLATE_DIR . '/base.phtml';