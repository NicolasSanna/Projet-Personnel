<?php

$template = 'categories';
$pageTitle = 'Categories';

$sql =  'SELECT *
        FROM categories 
        ORDER BY categories.category ASC;';

$categories = getAllResults($sql);


include TEMPLATE_DIR . '/base.phtml';