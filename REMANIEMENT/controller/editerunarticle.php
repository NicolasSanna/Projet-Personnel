<?php

require CONTROLLER_DIR . '/security.php';

$pageTitle = 'Éditer un article';
$template = 'editerunparticle';

if(isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET['id']) && $_GET['jeton'] == $_SESSION['jeton'])
{
    $idOfArticle = $_GET['id'];

    $sql = 'SELECT *
            FROM articles
            INNER JOIN categories ON articles.category_id = categories.id
            WHERE articles.id = ?;';

    $checkifArticleExists = executeQuery($sql, [$idOfArticle]);
    
    if($checkifArticleExists->rowCount() > 0)
    {
        $articleInfos = getOneResult($sql, [$idOfArticle]);

        if($articleInfos['user_id'] == $_SESSION['id'])
        {
            $title =  $articleInfos['title'];
            $content =  $articleInfos['content'];
            $category =  $articleInfos['category_id'];
            $category_label = $articleInfos['category'];

            $title = str_replace('<br />', '', $title);
            $content = str_replace('<br />', '', $content);

        }
        else
        {
            $_SESSION['error'] = "Vous ne pouvez pas modifier cet article car vous n'en êtes pas l'auteur.";
            header('Location:' . buildUrl('mesarticles'));
        }
    }
    else
    {
        $_SESSION['error'] = "L'article n'a pas pu être trouvé.";
        header('Location:' . buildUrl('homepage'));
    }
}
else
{
    $_SESSION['error'] = "L'article n'a pas pu être trouvé.";
    header('Location: ' . buildUrl('homepage'));
}

$sql = 'SELECT * 
        FROM categories;';

$categories = getAllResults($sql);

if(isset($_POST['validate']))
{
    if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['category']))
    {
        $newTitle = trim($_POST['title']);
        $newContent = trim(nl2br(htmlspecialchars($_POST['content'])));
        $newCategory = (int) $_POST['category'];

        if (!$newTitle || !$newContent || !$newCategory)
        {
            $_SESSION['error'] = "Tous les champs de modification n'ont pas été remplis.";
            header('Location: ' .  buildUrl('editerarticle', ['id' => intval($idOfArticle), 'jeton' => $_SESSION['jeton']]));
        }
        else
        {
            
            $sql = 'UPDATE articles 
                    SET title = ?, 
                    content = ?, 
                    category_id = ? 
                    WHERE id = ? ';

           $editArticleOnWebsite = executeQuery($sql, [$newTitle, $newContent, $newCategory, $idOfArticle]) ;

            $_SESSION['success'] = "Votre article a correctement été modifié.";
            header('Location: ' . buildUrl('mesarticles'));
        }
    }
    else
    {
        $_SESSION['error'] = "Vous n'avez pas rempli formulation de modification correctement.";
        header('Location: ' .  buildUrl('editerarticle', ['id' => intval($idOfArticle), 'jeton' => $_SESSION['jeton']]));
    }
}


include TEMPLATE_DIR . '/base.phtml';