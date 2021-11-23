<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\UserSession;


class AdministrationController extends AbstractController
{

    public function index()
    {
        if(!UserSession::isAuthenticated())
        {
            $this->redirect('accessRefused');
        }

        return $this->render('admin/administration');
    }
}