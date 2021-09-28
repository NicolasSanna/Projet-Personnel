<?php

$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8';

$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$sql = 'CALL SP_ArticlesLire();';

$pdoStatement = $pdo->prepare($sql);
$pdoStatement->execute();
$articles = $pdoStatement->fetchAll();

$template = 'forum';
$pageTitle = 'Accueil';

include TEMPLATE_DIR . '/base.phtml';