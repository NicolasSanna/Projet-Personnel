<?php 

// Configuration des chemins vers les répertoires
define('PROJECT_DIR', __DIR__);
define('CONTROLLER_DIR', PROJECT_DIR . '/controller');
define('TEMPLATE_DIR', PROJECT_DIR . '/templates');
define ('FILES_DIR', PROJECT_DIR . '/public/files');

// En local :

// Attention, changer le SITE_BASE_URL en cas de mise en ligne, et décommenter le .htaccess.
define('SITE_BASE_URL', 'http://localhost:8000');

define('DB_HOST', 'localhost');
define('DB_NAME', 'huma_scientio');
define('DB_USER', '4dm1n1str4teur');
define('DB_PASSWORD', 'B(v@!VR-q4XCmMzK');

define('DB_MS', 'mysql');
define('DB_PORT', '3306');
define('DB_CHARSET', 'utf8');

// En ligne :

// define('SITE_BASE_URL', 'http://humascientio.nicolassanna.com');
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'u516239589_huma_scientio');
// define('DB_USER', 'u516239589_4dm1n1str4teur');
// define('DB_PASSWORD', 'B(v@!VR-q4XCmMzK');

// define('DB_MS', 'mysql');
// define('DB_PORT', '3306');
// define('DB_CHARSET', 'utf8');