<?php

$pageTitle = 'Forum';
$template = 'forum';

$sql = 'SELECT articles.id AS id_article , title, content, creation_date, user_id, pseudo, category_id, categories.id AS id_category, category
        FROM articles
        INNER JOIN categories ON articles.category_id = categories.id
        INNER JOIN users ON articles.user_id = users.id
        ORDER BY articles.creation_date DESC;';

$getAllArticles =  getAllResults($sql);

include TEMPLATE_DIR . '/base.phtml';