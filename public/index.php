<?php

// Inclusion du fichier d'autoload de composer pour pouvoir utiliser les librairies externes téléchargées
require '../vendor/autoload.php';

// Inclusion du fichier de configuration
require '../config.php';

// Inclusion des dépendances (fichiers de fonctions)
require '../library/functions.php';

use App\Framework\Router;

$fullPath = $_SERVER['REQUEST_URI'] ?? '/';
$path = explode('?', $fullPath)[0];

// On va chercher les routes dans le fichier de configuration routes.php
$routes = include '../app/routes.php';

// Appel du Router pour récupérer le contrôleur à appeler (nom de la classe + nom de la méthode)
$router = new Router($routes);
$action = $router->match($path);

// On construit le nom complet de la classe de contrôleur
$classname = 'App\\Controller\\' . $action['controller'] . 'Controller';

// On instancie la classe de contrôleur
$controller = new $classname();

// On va cherche le nom de la méthode
$method = $action['method'];

// On appelle la méthode sur l'objet Contrôleur
echo $controller->$method();