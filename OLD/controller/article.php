<?php

$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';

$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$idArt = $_GET['id'];

$sql = 'SELECT *
       FROM article
       WHERE id_art = ?';

$pdoStatement = $pdo->prepare($sql);
$pdoStatement->execute([$idArt]);
$article = $pdoStatement->fetch();

$template = 'article';
$pageTitle = $article['nom_article'];

include TEMPLATE_DIR . '/base.phtml';