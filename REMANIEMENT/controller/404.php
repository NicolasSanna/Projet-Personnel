<?php

http_response_code(404);

$template = 'unfindPage';
$pageTitle = 'Page introuvable';

include TEMPLATE_DIR . '/base.phtml';