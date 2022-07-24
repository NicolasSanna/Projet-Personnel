<?php

namespace App\Controller\Admin;

use App\Framework\Get;
use App\Framework\File;
use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CategoryModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;
use App\Framework\Server;

class ArticleController extends AbstractController
{
    public function new()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategoriesForArticle();
            $pageTitle = 'Créer un nouvel article';

            if(!empty($_POST))
            {
                $title =  trim($_POST['title']);
                $content =  str_contains($_POST['content'], '<script>') ? trim(htmlspecialchars($_POST['content'])) : trim($_POST['content']);
                $category = (int) $_POST['categories'];
                $id_user = UserSession::getId();
                $file = $_FILES['image'];
                $token = $_POST['token'];
    
                if(!$title || !$content || !$category)
                {
                    FlashBag::addFlash("Tous les champs n'ont pas été correctement remplis.", 'error');
                }

                if($token != UserSession::token())
                {
                    FlashBag::addFlash("Une erreur s'est produite lors de l'ajout de l'article.", 'error');
                }

                if(!empty($file['name']))
                {                                    
                    $fileModel = new File();
                    $fileName = $fileModel->UploadFileImage($file);
                }
                
                if (!(FlashBag::hasMessages('error')))
                {

                    
                    $articleModel = new ArticleModel();
                    $articleCreate = $articleModel->insertArticle($title, $content, $category, $id_user, $fileName);
                    FlashBag::addFlash("Votre article a bien été ajouté. Il sera approuvé prochainement.", 'success');
                    return $this->redirect('myarticles');
                }
            }      
            
            return $this->render('admin/article/new', [
                'content' => $content??'',
                'title' => $title??'',
                'categories' => $categories??'',
                'pageTitle' => $pageTitle??'',
                'selectedCategory' => $category??null
            ]);
        }
        else
        {
            return $this->redirect('accessRefused');
        }
    }

    public function myArticles()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            $id_user = UserSession::getId();
            $articleModel = new ArticleModel();
            $myArticles = $articleModel->getMyarticles($id_user);

            $pageTitle = 'Mes articles';
            

        }
        else
        {
            $this->redirect('accessRefused');
        }

        
        return $this->render('admin/article/myarticles', [
            'myArticles' => $myArticles??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function modifyarticle()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (Get::existsDigit('id'))
            {
                $idOfArticle = Get::key('id');
            }
            else
            {
                $this->redirect('myarticles');
            }
    
            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticleToUpdateForUser($idOfArticle);

            $pageTitle = 'Modifer un article';

            $categoriesModel = new CategoryModel();
            $categories = $categoriesModel->getAllCategoriesForArticle();
    
            if(!$checkArticle)
            {
                FlashBag::addFlash("Aucun article n'existe sous cet identifiant", 'error');
                $this->redirect('myarticles');
            }

            $id_user = UserSession::getId();        
            $title = $checkArticle['title'];
            $content = $checkArticle['content'];
            $imageExist = $checkArticle['image'];
            $defaultCategory = $checkArticle['category_id'];
    
            if($checkArticle['user_id'] != UserSession::getId())
            {
                FlashBag::addFlash("Vous ne pouvez pas modifier cet article, car vous n'en n'êtes pas l'auteur", 'error');
                $this->redirect('myarticles');
            }

            if(!empty($_POST))
            {
                $newtitle =  trim($_POST['title']);
                $newcontent =  str_contains($_POST['content'], '<script>') ? trim(htmlspecialchars($_POST['content'])) : trim($_POST['content']) ;
                $category = (int) $_POST['categories'];
                $token = $_POST['token'];
                $file = $_FILES['image'];

                if (!$newtitle || !$newcontent || !$category)
                {
                    FlashBag::addFlash("Tous les champs de modification n'ont pas été remplis.", 'error');
                }

                if($token != UserSession::token())
                {
                    FlashBag::addFlash("Une erreur s'est produite lors de la modification.", 'error');
                }

                if(!empty($file['name']))
                {                  
                    $fileModel = new File();

                    $fileName = $fileModel->uploadFileImage($file, $imageExist);
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    $articleModel = new ArticleModel();
                    $updateArticle = $articleModel->modifyarticle($idOfArticle, $id_user, $newtitle, $newcontent, $category, $fileName);
                    FlashBag::addFlash("Article modifié avec succès!", 'success');
                    $this->redirect('myarticles');
                }
            }
            return $this->render('admin/article/modifyArticle', [
                'content' => $newcontent??$content,
                'title' => $newtitle??$title,
                'categories' => $categories??'',
                'pageTitle' => $pageTitle??'',
                'imageExist' => $imageExist??'',
                'idOfArticle' => $idOfArticle??'',
                'selectedCategory' => $category??$defaultCategory
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
            if (Get::existsDigit('id') && array_key_exists('token', $_GET) && $_GET['token'])
            {
                $idOfArticle = Get::key('id');
                $token = Get::key('token');
            }
            else
            {
                return $this->redirect('myarticles');
            }
    
            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticleToUpdateForUser($idOfArticle);
            $id_user = UserSession::getId();

            if(Server::ajaxIsOkay())
            {
                if(!$checkArticle)
                {
                    FlashBag::addFlash("Aucun article n'existe sous cet identifiant", 'error');
                }
    
                if($checkArticle['user_id'] != UserSession::getId())
                {
                    FlashBag::addFlash("Vous ne pouvez pas supprimer cet article, car vous n'en n'êtes pas l'auteur", 'error');
                }   
    
                if($token != UserSession::token())
                {
                    FlashBag::addFlash("Une erreur s'est produite lors de la suppression.", 'error');
                }
    
                if (!(FlashBag::hasMessages('error')))
                {
                    if(!empty($checkArticle['image']))
                    {
                        unlink(IMAGE_DIR . '/' . $checkArticle['image']);
                    }
                    $articleModel = new ArticleModel();
                    $deleteArticle = $articleModel->deleteArticle($idOfArticle, $id_user);
    
                    echo json_encode($idOfArticle);
                } 
            }
            else
            {
                return $this->redirect('accessRefused');
            }
        }
        else
        {
            return $this->redirect('accessRefused');
        }
    }

    public function deleteImage()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (Get::existsDigit('id'))
            {
                $idOfArticle = Get::key('id');
            }
            else
            {
                return $this->redirect('myarticles');
            }

            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticleToUpdateForUser($idOfArticle);
            $imageExist = $checkArticle['image'];

            if(!$checkArticle)
            {
                FlashBag::addFlash("Aucun article n'existe sous cet identifiant", 'error');
                return $this->redirect('myarticles');
            }

            if($checkArticle['user_id'] != UserSession::getId())
            {
                FlashBag::addFlash("Vous ne pouvez pas supprimer cette image de cet article, car vous n'en n'êtes pas l'auteur", 'error');
                return $this->redirect('myarticles');
            }  

            if (!(FlashBag::hasMessages('error')))
            {
                $articleModel = new ArticleModel();
                $deleteImageArticle = $articleModel->deleteImageArticle($idOfArticle);
                unlink(IMAGE_DIR . '/' . $imageExist);
                return $this->redirect('modifyarticle', ['id' => $idOfArticle]);
            }
        }
        else
        {
            return $this->redirect('accessRefused');
        }       
    }
}