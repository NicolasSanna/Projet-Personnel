<?php

namespace App\Controller\Admin;

use App\Framework\Get;
use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class AdministrationArticlesController extends AbstractController
{
    public function adminArticlesByAdministrator()
    {
        if (UserSession::administrator())
        {
            $articleModel = new ArticleModel();
            $notApprouvedArticles = $articleModel->allArticlesNotApprouved();

            $pageTitle = 'Gérer les articles des membres';
        }
        else
        {
            return $this->redirect('accessRefused');
        }

       return $this->render('admin/adminArticles', [
        'pageTitle' => $pageTitle,
        'notApprouvedArticles' => $notApprouvedArticles
        ]);
    }

    public function approuveArticle()
    {
                
        if(UserSession::administrator())
        {
            if (Get::existsDigit('id'))
            {
                $idOfArticle = Get::key('id');
                $token = Get::key('token');
                $articleModel = new ArticleModel();
                $article = $articleModel->getOneArticleToUpdate($idOfArticle);

                if(!$article)
                {
                    FlashBag::addFlash("Cet article n'existe pas.", 'error');
                    return $this->redirect('administration');
                }

                if ($token != UserSession::token())
                {
                    FlashBag::addFlash("Erreur à l'approbation de l'article", 'error');
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    $articleModel = new ArticleModel();
                    $approuveArticle = $articleModel->approuveArticle($idOfArticle);
                    FlashBag::addFlash("L'article a bien été approuvé", 'success');
                    return $this->redirect('adminArticles');
                }
            }
        }
        else
        {
            return $this->redirect('accessRefused');
        }

    }

    public function deleteNotApprouvedArticle()
    {
        if(UserSession::administrator())
        {
            if (Get::existsDigit('id'))
            {
                $idOfArticle = Get::key('id');
                $token = Get::key('token');
                $articleModel = new ArticleModel();
                $article = $articleModel->getOneArticleToUpdate($idOfArticle);

                if(!$article)
                {
                    FlashBag::addFlash("Cet article n'existe pas.", 'error');
                }

                if ($token != UserSession::token())
                {
                    FlashBag::addFlash("Erreur à la suppression de l'article", 'error');
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    $articleModel = new ArticleModel();
                    $approuveArticle = $articleModel->deleteNotApprouvedArticle($idOfArticle);
                    FlashBag::addFlash("L'article a bien été supprimé", 'success');
                    
                }
                return $this->redirect('adminArticles');
            }
        }
        else
        {
            return $this->redirect('accessRefused');
        }
    }
}