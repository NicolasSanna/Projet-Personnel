<?php 

$template = 'article';
$pageTitle = 'Article';

if(isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET['id']))
{
    $idOfArticle = $_GET['id'];

        $sql = 'SELECT articles.id AS id_article , title, content, creation_date, user_id, pseudo, category_id, categories.id AS id_category, category 
                FROM articles 
                INNER JOIN categories ON articles.category_id = categories.id 
                INNER JOIN users ON articles.user_id = users.id 
                WHERE articles.id = ?';

    $checkifArticleExists = executeQuery($sql, [$idOfArticle]);

    if($checkifArticleExists->rowCount() == 0)
    {  
        $_SESSION['error'] = "L'article recherché n'existe pas.";
        header('Location:' . buildUrl('homepage'));
    }
    else 
    {
        $articleInfos = getOneResult($sql, [$idOfArticle]);
    }   
}
else
{
    $_SESSION['error'] = "Aucun élément.";
    header('Location:' . buildUrl('homepage'));
}

$sql = 'SELECT date_publication, content, comments.id AS comment_id, article_id, user_id, pseudo
        FROM comments
        INNER JOIN users ON comments.user_id = users.id
        WHERE comments.article_id = ?
        ORDER BY comments.date_publication DESC;';

$CommentsOfThisArticle = getAllResults($sql, [$idOfArticle]);


if(isset($_POST['validate']))
{
    if(!empty($_POST['answer']))
    {
        $userComment = trim(nl2br(htmlspecialchars($_POST['answer'])));
        
        if(!$userComment)
        {
            $_SESSION['error'] = "Le commentaire n'a pas été rempli correctement.";
            header('Location: ' .  buildUrl('article', ['id' => intval($idOfArticle)]));

            
        }
        else
        {

        $sql = 'INSERT INTO comments (content, user_id, article_id, date_publication)
                VALUES
                (?, ?, ?, NOW());';

        $insertComment = executeQuery($sql, [$userComment, $_SESSION['id'], $idOfArticle]);
        
        

        $_SESSION['success'] = "Votre commentaire a bien été enregistré !";
        header('Location: ' .  buildUrl('article', ['id' => intval($idOfArticle)]));
        }

    }
    else
    {
        $_SESSION['error'] = "Vous n'avez pas rempli le formulaire de commentaire correctement.";
        header('Location: ' .  buildUrl('article', ['id' => intval($idOfArticle)]));
    }
}

include TEMPLATE_DIR . '/base.phtml';