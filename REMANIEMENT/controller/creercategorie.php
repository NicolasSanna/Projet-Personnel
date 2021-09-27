<?php 

require CONTROLLER_DIR . '/administratorsecurity.php';

$pageTitle = 'Créer une catégorie';
$template = 'creercategorie';

if(isset($_POST['validate']))
{
    if(!empty($_POST['category']))
    {
        $category = trim(htmlspecialchars($_POST['category']));
        
        if(!$category)
        {
            $_SESSION['error'] = "Le champ catégorie est vide.";
            header('Location:' . buildUrl('creercategorie'));
        }
        else
        {
            $sql = 'CALL SP_CategoryCreate(?)';

            $_SESSION['query'] = getOneResult($sql, [$category]);
            header('Location:' . buildUrl('creercategorie'));
        }
    }
    else
    {
        $_SESSION['error'] = "Veuillez entrer le nom d'une catégorie.";
        header('Location:' . buildUrl('creercategorie'));
    }

}



include TEMPLATE_DIR . '/base.phtml';