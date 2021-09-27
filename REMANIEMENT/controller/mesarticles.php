<?php 

require CONTROLLER_DIR . '/security.php';

$template = 'mesarticles';
$pageTitle = 'Mes articles';

$sql = 'SELECT articles.id AS article_id, title, content, user_id, category_id, creation_date, categories.id AS category_id, category
FROM articles 
INNER JOIN categories ON articles.category_id = categories.id 
WHERE articles.user_id = ? 
ORDER BY articles.creation_date DESC;';

$myArticles = getAllResults($sql, [$_SESSION['id']]);

include TEMPLATE_DIR . '/base.phtml';