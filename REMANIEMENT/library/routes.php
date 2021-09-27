<?php

$fullPath = $_SERVER['REQUEST_URI'] ?? '/';
$path = explode('?', $fullPath)[0];

$routes = [

    'homepage' => [
        'path' => '/',
        'controller' => 'home.php'
    ],
    'connexion' => [
        'path' => '/connexion',
        'controller' => 'connexion.php'
    ],
    'deconnexion' => [
        'path' => '/deconnexion',
        'controller' => 'deconnexion.php'
    ],
    'creerunarticle' => [
        'path' => '/unarticle',
        'controller' => 'creerunarticle.php'
    ],
    'accesrefuse' => [
        'path' => '/accessRefused',
        'controller' => 'accessRefused.php'
    ],
    'mesarticles' => [
        'path' => '/mesarticles',
        'controller' => 'mesarticles.php'
    ],
    'editerarticle' => [
        'path' => '/editerunarticle',
        'controller' => 'editerunarticle.php'
    ],
    'article' => [
        'path' => '/article',
        'controller' => 'article.php'
    ],
    'supprimerarticle' => [
        'path' => '/supprimerarticle',
        'controller' => 'supprimerarticle.php'
    ],
    'categories' => [
        'path' => '/categories',
        'controller' => 'categories.php'
    ],
    'categorie' => [
        'path' => '/categorie',
        'controller' => 'categorie.php'
    ],
    'inscription' => [
        'path' => '/inscription',
        'controller' => 'inscription.php'
    ],
    'motdepasseoublie' => [
        'path' => '/motdepasseoublie',
        'controller' => 'motdepasseoublie.php'
    ],
    'creercategorie' => [
        'path' => '/creercategorie',
        'controller' => 'creercategorie.php'
    ],
    'forum' => [
        'path' => '/forum',
        'controller' => 'forum.php'
    ]
];

if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

if (!isset($_SESSION['jeton'])) 
{
   $_SESSION['jeton'] = bin2hex(openssl_random_pseudo_bytes(6));
}

if (isset($_SESSION['error']))
{
    $errorMsg = $_SESSION['error'];
    $_SESSION['error'] = null;
}

if(isset($_SESSION['success']))
{
    $successMsg = $_SESSION['success'];
    $_SESSION['success'] = null;
}

if(isset($_SESSION['query']))
{
    $querySPMsg = $_SESSION['query'];
    $_SESSION['query'] = null;
}
 
$controller = null;
foreach ($routes as $route) 
{
   if ($route['path'] === $path) 
   {
       $controller = $route['controller'];
       break;
   }
}

define('ROUTES', $routes);

$controller = $controller ?? '404.php';

require CONTROLLER_DIR . '/' . $controller;