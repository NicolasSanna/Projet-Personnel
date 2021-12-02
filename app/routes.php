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
        'path' => '/forum/article',
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
        'path' => '/administration/creerunarticle',
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
        'path' => '/administration/administrerutilisateurs',
        'controller' => 'Admin\\AdministrationUser',
        'method' => 'administrationUsers'
    ],
    'deleteUser' => [
        'path' => '/administration/supprimerutilisateur',
        'controller' => 'Admin\\AdministrationUser',
        'method' => 'deleteUser'
    ],
    'myarticles' => [
        'path' => '/administration/mesarticles',
        'controller' => 'Admin\\Article',
        'method' => 'myArticles'
    ], 
    'deletearticle' => [
        'path' => '/administraiton/supprimerarticle',
        'controller' => 'Admin\\Article',
        'method' => 'deleteMyArticle',
    ],
    'modifyarticle' => [
        'path' => '/administration/modifierarticle',
        'controller' => 'Admin\\Article',
        'method' => 'modifyarticle'
    ],
    'addcomment' => [
        'path' => '/forum/ajoutercommentaire',
        'controller' => 'Article',
        'method' => 'addComment'
    ],
    'addCategory' => [
        'path' => '/administration/ajouterunecategorie',
        'controller' => 'Admin\\AdministrationCategory',
        'method' => 'addCategory'
    ],
    'adminCategories' => [
        'path' => '/administration/administrerlescategories',
        'controller' => 'Admin\\AdministrationCategory',
        'method' => 'adminCategories'
    ],
    'modifygrantuser' => [
        'path' => '/administration/modifierprivilegeutilisateur',
        'controller' => 'Admin\\AdministrationUser',
        'method' => 'modifyGrantUser'
    ],
    'modifycategory' => [
        'path' => '/administration/modifiercategorie',
        'controller' => 'Admin\\AdministrationCategory',
        'method' => 'modifyCategory'
    ],
    'deletecategory' => [
        'path' => '/administration/supprimercategorie',
        'controller' => 'Admin\\AdministrationCategory',
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
    'commentsAdministration' => [
        'path' => '/administration/commentaires',
        'controller' => 'Admin\\AdministrationComments',
        'method' => 'adminCommentsNotApprouved'
    ],
    'commentApprouved' => [
        'path' => '/administration/approuvercommentaire',
        'controller' => 'Admin\\AdministrationComments',
        'method' => 'commentApprouved'
    ],
    'commentDelete' => [
        'path' => '/administration/supprimercommentaire',
        'controller' => 'Admin\\AdministrationComments',
        'method' => 'commentRefused'
    ],
    'allCommentsApprouved' => [
        'path' => '/administration/approuvertouslescommentaires',
        'controller' => 'Admin\\AdministrationComments',
        'method' => 'AllCommentsApprouved'
    ],
    'search' => [
        'path' => '/rechercher',
        'controller' => 'Forum',
        'method' => 'search'
    ],
    'deleteImage' => [
        'path' => '/administration/supprimerimage',
        'controller' => 'Admin\\Article',
        'method' => 'deleteImage'
    ],

    'modifyPassword' => [
        'path' => '/modifierlemotdepasse',
        'controller' => 'Auth',
        'method' => 'changePassword'
    ],

    // Mettre cette route en tout dernier si aucune ne correspond. /!\
    '404' => [
        'path' => $path,
        'controller' => 'Home',
        'method' => 'notFound'
    ]
];

// On fait de route une constante.
define('ROUTES', $routes);

// On renvoie le tableau associatif de routes.
return $routes;