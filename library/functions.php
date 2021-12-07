<?php

/**
 * La fonction asset permet de faire appel aux différents fichiers venant des dossiers du dossier public : css, js, img,... Elle prend en paramètre le chemin à partir de l'index.php.
 */
function asset(string $path): string 
{
    return SITE_BASE_URL . '/' . $path;
}

/**
 * La fonction buildUrl prend en paramètre le nom de la route venant du tableau de routes de routes.php, en second paramètre, elle peut recevoir des éléments GET.
 */
function buildUrl(string $routeName, array $params = []): string
{
    // Si la clé route venant de la constante ROUTES n'existe pas on retourne faux.
    if (!array_key_exists($routeName, ROUTES)) 
    {
        return false;
    }

    // L'URL définie vient du path du nom de la route du tableau associatif de la constante ROUTES.
    $url = ROUTES[$routeName]['path'];

    // S'il y a des paramètres, (des $_GET dans l'URL notamment)
    if ($params) 
    {
        // On concatène à l'URL le point d'interrogation qui est le séparateur en PHP permettant l'entrée de paramètres, et l'on construit l'adresse complète avec les paramètres ($_GET, et autres)
        $url .= '?' . http_build_query($params);
    }

    return $url;
}


