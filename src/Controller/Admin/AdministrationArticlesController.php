<?php

namespace App\Controller\Admin;

use App\Framework\UserSession;
use App\Framework\AbstractController;

class AdministrationArticlesController extends AbstractController
{
    public function adminArticlesByAdministrator()
    {
        if (UserSession::administrator())
       {
            
       }
       else
       {
           return $this->redirect('accessRefused');
       }

       return $this->render('admin/adminArticles');
    }
}