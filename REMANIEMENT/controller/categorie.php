<?php

$pageTitle = 'Catégorie';
$template = 'categorie';

if(isset($_GET['id']) && !empty($_GET['id']) && ctype_digit($_GET['id']))
{
    $idOfCategory = $_GET['id'];

    $sql = 'SELECT articles.id AS id_article , title, content, user_id, category_id, creation_date, categories.id AS id_category, category, pseudo
            FROM articles
            INNER JOIN categories ON articles.category_id = categories.id
            INNER JOIN users ON articles.user_id = users.id
            WHERE categories.id = ?
            ORDER BY creation_date DESC;';

    $checkIfCategoryExists = executeQuery($sql, [$idOfCategory]);

    if($checkIfCategoryExists->rowCount() == 0)
    {
        $_SESSION['error'] = "Il n'y aucun article associé à cette catégorie ou la catégorie n'existe pas.";
        header('Location:' . buildUrl('categories'));
    }
    else 
    {
        $articlesbyCategory = getAllResults($sql, [$idOfCategory]);
    }
}
else
{
    $_SESSION['error'] = "La catégorie recherchée n'existe pas.";
    header('Location:' . buildUrl('categories'));
}

include TEMPLATE_DIR . '/base.phtml';