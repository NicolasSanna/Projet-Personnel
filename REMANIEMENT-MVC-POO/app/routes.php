<?php 

/**
 * On définit le tableau des routes : on associe à chaque route une classe
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
    ],
    'newarticle' => [
        'path' => '/admin/new',
        'controller' => 'Admin\\Article',
        'method' => 'new'
    ],
    'accessRefused' => [
        'path' => '/accessRefuse',
        'controller' => 'Home',
        'method' => 'refused'
    ],
    'administration' => [
        'path' => '/administration',
        'controller' => 'Admin\\Administration',
        'method' => 'index'
    ],
    'adminusers' => [
        'path' => '/administrerutilisateurs',
        'controller' => 'Admin\\Administration',
        'method' => 'administrationUsers'
    ],
    'deleteUser' => [
        'path' => '/supprimerutilisateur',
        'controller' => 'Admin\\Administration',
        'method' => 'deleteUser'
    ],
    'myarticles' => [
        'path' => '/mesarticles',
        'controller' => 'Admin\\Article',
        'method' => 'myArticles'
    ], 
    'deletearticle' => [
        'path' => '/supprimerarticle',
        'controller' => 'Admin\\Article',
        'method' => 'deleteMyArticle',
    ],
    'modifyarticle' => [
        'path' => '/modifierarticle',
        'controller' => 'Admin\\Article',
        'method' => 'modifyarticle'
    ],
    'addcomment' => [
        'path' => '/ajoutercommentaire',
        'controller' => 'Article',
        'method' => 'addComment'
    ],
    'addCategory' => [
        'path' => '/ajouterunecategorie',
        'controller' => 'Admin\\Administration',
        'method' => 'addCategory'
    ],
    'adminCategories' => [
        'path' => '/administrerlescategories',
        'controller' => 'Admin\\Administration',
        'method' => 'adminCategories'
    ],
    'modifygrantuser' => [
        'path' => '/modifierprivilegeutilisateur',
        'controller' => 'Admin\\Administration',
        'method' => 'modifyGrantUser'
    ],
    'modifycategory' => [
        'path' => '/modifiercategorie',
        'controller' => 'Admin\\Administration',
        'method' => 'modifyCategory'
    ],
    'deletecategory' => [
        'path' => '/supprimercategorie',
        'controller' => 'Admin\\Administration',
        'method' => 'deleteCategory'
    ],
    'categories' => [
        'path' => '/forum/categories',
        'controller' => 'Forum',
        'method' => 'seeAllCategories'
    ],
    'category' => [
        'path' => '/forum/categorie',
        'controller' => 'Forum',
        'method' => 'seeOneCategoryAndArticles'
    ],
    // Mettre cette route en tout dernier /!\
    '404' => [
        'path' => $_SERVER['REQUEST_URI'],
        'controller' => 'Home',
        'method' => 'notFound'
    ]
];

define('ROUTES', $routes);

return $routes;