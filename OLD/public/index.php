<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';
require __DIR__ . '/../library/functions.php';

$path = $_SERVER['PATH_INFO'] ?? '/';

$routes = [];
$routes['homepage'] = [
   'path' => '/',
   'controller' => 'home.php'
];
$routes['forum'] = [
   'path' => '/forum',
   'controller' => 'forum.php'
];
$routes['article'] = [
    'path' => '/article',
    'controller' => 'article.php'
 ];
$routes['categorie'] = [
   'path' => '/categorie',
   'controller' => 'categorie.php'
];
$controller = null;
foreach ($routes as $route) {
   if ($route['path'] === $path) {
       $controller = $route['controller'];
       break;
   }
}

ob_start();

require __DIR__ . '/../controller/' . $controller;

$content = ob_get_clean();

echo $content;