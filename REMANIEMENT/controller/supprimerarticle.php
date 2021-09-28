<?php

require CONTROLLER_DIR . '/security.php';

$pageTitle = 'Supprimer un article';

if(isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET['id']) && $_GET['jeton'] == $_SESSION['jeton'])
{
    $idOfTheArticle = $_GET['id'];

    $sql = 'SELECT * 
            FROM articles
            WHERE id = ?';

    $checkIfArticleExists = executeQuery($sql, [$idOfTheArticle]);

    if($checkIfArticleExists->rowCount() > 0)
    {
        $usersInfos = getOneResult($sql, [$idOfTheArticle]);

        if($usersInfos['user_id'] == $_SESSION['id'])
        {

            $sql = 'DELETE 
                    FROM articles 
                    WHERE id = ?';

            $deleteThisArticle = executeQuery($sql, [$idOfTheArticle]);
            $_SESSION['success'] = 'Article supprimé avec succès.';

            header('Location: ' . buildUrl('mesarticles'));
        }
        else
        {
            $_SESSION['error'] = "Vous ne pouvez pas supprimer un article appartenant à un autre auteur.";
            header('Location: ' . buildUrl('mesarticles'));
        }
    }
    else
    {
        $_SESSION['error'] = "Aucun article n'a été trouvé.";
        header('Location: ' . buildUrl('mesarticles'));
    }
}
else
{
    $_SESSION['error'] = "Aucun article n'a été trouvé.";
    header('Location: ' . buildUrl('mesarticles'));
}

include TEMPLATE_DIR . '/base.phtml';