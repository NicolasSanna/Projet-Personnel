<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Model\CategoryModel;
use App\Model\ArticleModel;
use App\Framework\UserSession;

class ArticleController extends AbstractController
{
    public function new()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategoriesForArticle();

            if(!empty($_POST))
            {
                $title = trim(htmlspecialchars($_POST['title']));
                $content = trim(nl2br(htmlspecialchars($_POST['content'])));
                $category = (int) $_POST['categories'];
                $id_user = UserSession::getId();
    
                if(!$title || !$content || !$category)
                {
                    FlashBag::addFlash("Tous les champs n'ont pas été correctements remplis.", 'error');
                }
                else
                {
                    $articleModel = new ArticleModel();
                    $articleCreate = $articleModel->insertArticle($title, $content, $category, $id_user);

                    FlashBag::addFlash("Votre article a bien été ajouté !", 'success');
                }
            }      
            
            return $this->render('admin/article/new', [
                'content' => $content??'',
                'title' => $title??'',
                'categories' => $categories??''
            ]);
        }
        else
        {
            $this->redirect('accessRefused');
        }



    }

    public function myArticles()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            $id_user = UserSession::getId();

            $articleModel = new ArticleModel();
    
            $myArticles = $articleModel->getMyarticles($id_user);
            

            return $this->render('admin/article/myarticles', [
                'myArticles' => $myArticles
            ]);
        }
        else
        {
            $this->redirect('accessRefused');
        }
    }

    public function modifyarticle()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id'])) 
            {
                $idOfArticle = $_GET['id'];
            }
    
            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticle($idOfArticle);
            $id_user = UserSession::getId();
            
            $title = $checkArticle['title'];
            $content = $checkArticle['content'];
            $categoriesModel = new CategoryModel();
    
            $categories = $categoriesModel->getAllCategoriesForArticle();
    
            if(!$checkArticle)
            {
                FlashBag::addFlash("Aucun article n'existe sous cet identifiant", 'error');
                $this->redirect('myarticles');
            }
            else
            {
    
                if($checkArticle['user_id'] != UserSession::getId())
                {
                    FlashBag::addFlash("Vous ne pouvez pas modifier cet article, car vous n'en n'êtes pas l'auteur", 'error');
                    $this->redirect('myarticles');
                }
                else
                {
                    if(!empty($_POST))
                    {
                        $newtitle = htmlspecialchars(trim($_POST['title']));
                        $newcontent = trim(nl2br(htmlspecialchars($_POST['content'])));
                        $category = (int) $_POST['categories'];
        
                        if (!$newtitle || !$newcontent || !$category)
                        {
                            FlashBag::addFlash("Tous les champs de modification n'ont pas été remplis.", 'error');
                        }
                        else
                        {
                            $articleModel = new ArticleModel();
                            $updateArticle = $articleModel->modifyarticle($idOfArticle, $id_user, $newtitle, $newcontent, $category);
                            FlashBag::addFlash("Article modifié avec succès!", 'success');
                            $this->redirect('myarticles');
                        }
                    }
                }
            }
            return $this->render('admin/article/modifyarticle', [
                'content' => $content??'',
                'title' => $title??'',
                'categories' => $categories??''
            ]);
        }
        else
        {
            $this->redirect('accessRefused');
        }

    }

    public function deleteMyArticle()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id'])) 
            {
                $idOfArticle = $_GET['id'];
            }
    
            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticle($idOfArticle);
            $id_user = UserSession::getId();
    
            if(!$checkArticle)
            {
                FlashBag::addFlash("Aucun article n'existe sous cet identifiant", 'error');
            }
            else
            {
                if($checkArticle['user_id'] != UserSession::getId())
                {
                    FlashBag::addFlash("Vous ne pouvez pas supprimer cet article, car vous n'en n'êtes pas l'auteur", 'error');
                }
                else
                {
                    
                    $articleModel = new ArticleModel();
                    $deleteArticle = $articleModel->deleteArticle($idOfArticle, $id_user);
                    FlashBag::addFlash("Article supprimé !", 'success');
                }
            }

            $this->redirect('myarticles');
        }
        else
        {
            $this->redirect('accessRefused');
        }
    }
}