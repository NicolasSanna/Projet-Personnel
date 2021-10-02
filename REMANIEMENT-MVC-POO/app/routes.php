<?php 

/**
 * On définit le tableau des routes : on associe à chaque route un fichier PHP 
 * qui jouera la rôle de contrôleur. Par exemple pour la page d'accueil, c'est un fichier home.php
 * qui sera inclus. Pour la page Article, ce sera un fichier article.php, etc
 */
$routes = [

    // Route de la page d'accueil
    'homepage' => [
        'path' => '/',
        'controller' => 'Home',
        'method' => 'index'
    ],
    'forum' => [
        'path' => '/forum',
        'controller' => 'Forum',
        'method' => 'index'
    ],
    'article' => [
        'path' => '/article',
        'controller' => 'Article',
        'method' => 'index'
    ],
    'signup' => [
        'path' => '/inscription',
        'controller' => 'Account',
        'method' => 'signup'
    ],
    'connexion' => [
        'path' => '/connexion',
        'controller' => 'Auth',
        'method' => 'login'
    ],
    'deconnexion' => [
        'path' => '/deconnexion',
        'controller' => 'Auth',
        'method' => 'logout'
    ]
];

define('ROUTES', $routes);

return $routes;