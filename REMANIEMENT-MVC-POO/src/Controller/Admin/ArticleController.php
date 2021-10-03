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
        if(!UserSession::isAuthenticated())
        {
            $this->redirect('accessRefused');
        }
        else
        {
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategories();

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

    }
}