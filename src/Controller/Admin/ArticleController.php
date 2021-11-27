<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\CategoryModel;
use App\Model\ArticleModel;

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
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);
                $category = (int) $_POST['categories'];
                $id_user = UserSession::getId();
                $file = $_FILES['image'];

                $fileName = '';
    
                if(!$title || !$content || !$category)
                {
                    FlashBag::addFlash("Tous les champs n'ont pas été correctements remplis.", 'error');
                }

                if(!empty($file['name']))
                {                  
                    if($file['error'] > 0)
                    {
                        FlashBag::addFlash("Une erreur est survenue lors du chargement du fichier.", 'error');
                    }

                    $fileName = $file['name'];
                    $fileExtension = "." . strtolower(substr(strrchr($fileName, "."), 1));

                    $validExtension = ['.img', '.png', '.jpgx', '.jpeg', '.jpg'];

                    if(!in_array($fileExtension, $validExtension))
                    {
                        FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
                    }
                    else
                    {
                        
                        $uniqueName = md5(uniqid(rand(), true));
                        $fileName = $uniqueName . $fileExtension;
                    }
                }
                
                if (!(FlashBag::hasMessages('error')))
                {
                    move_uploaded_file($file['tmp_name'], IMAGE_DIR  . $fileName);
                    $articleModel = new ArticleModel();
                    $articleCreate = $articleModel->insertArticle($title, $content, $category, $id_user, $fileName);
                    FlashBag::addFlash("Votre article a bien été ajouté.", 'success');
                }
            }      
            
            return $this->render('admin/article/new', [
                'content' => $content??'',
                'title' => $title??'',
                'categories' => $categories??'',
                'pageTitle' => $pageTitle??''
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
            if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
            {
                $idOfArticle = $_GET['id'];
            }
            else
            {
                $this->redirect('myarticles');
            }
    
            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticle($idOfArticle);

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
    
            if($checkArticle['user_id'] != UserSession::getId())
            {
                FlashBag::addFlash("Vous ne pouvez pas modifier cet article, car vous n'en n'êtes pas l'auteur", 'error');
                $this->redirect('myarticles');
            }

            if(!empty($_POST))
            {
                $newtitle = htmlspecialchars(trim($_POST['title']));
                $newcontent = trim(nl2br(htmlspecialchars($_POST['content'])));
                $category = (int) $_POST['categories'];
                $file = $_FILES['image'];
                $fileName = '';

                if (!$newtitle || !$newcontent || !$category)
                {
                    FlashBag::addFlash("Tous les champs de modification n'ont pas été remplis.", 'error');
                }


                if(!empty($file['name']))
                {                  
                    if($file['error'] > 0)
                    {
                        FlashBag::addFlash("Une erreur est survenue lors du chargement du fichier.", 'error');
                    }

                    $fileName = $file['name'];
                    $fileExtension = "." . strtolower(substr(strrchr($fileName, "."), 1));

                    $validExtension = ['.img', '.png', '.jpgx', '.jpeg', '.jpg'];

                    if(!in_array($fileExtension, $validExtension))
                    {
                        FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
                    }
                    else
                    {
                        
                        $uniqueName = md5(uniqid(rand(), true));
                        $fileName = $uniqueName . $fileExtension;
                    }
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    unlink(IMAGE_DIR . $imageExist);
                    move_uploaded_file($file['tmp_name'], IMAGE_DIR  . $fileName);
                    $articleModel = new ArticleModel();
                    $updateArticle = $articleModel->modifyarticle($idOfArticle, $id_user, $newtitle, $newcontent, $category, $fileName);
                    FlashBag::addFlash("Article modifié avec succès!", 'success');
                    $this->redirect('myarticles');
                }
            }
            return $this->render('admin/article/modifyarticle', [
                'content' => $content??'',
                'title' => $title??'',
                'categories' => $categories??'',
                'pageTitle' => $pageTitle??'',
                'imageExist' => $imageExist??''
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
            if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
            {
                $idOfArticle = $_GET['id'];
            }
            else
            {
                $this->redirect('myarticles');
            }
    
            $articleModel = new ArticleModel();
            $checkArticle = $articleModel->getOneArticle($idOfArticle);
            $id_user = UserSession::getId();
    
            if(!$checkArticle)
            {
                FlashBag::addFlash("Aucun article n'existe sous cet identifiant", 'error');
            }

            if($checkArticle['user_id'] != UserSession::getId())
            {
                FlashBag::addFlash("Vous ne pouvez pas supprimer cet article, car vous n'en n'êtes pas l'auteur", 'error');
            }   

            if (!(FlashBag::hasMessages('error')))
            {
                $articleModel = new ArticleModel();
                $deleteArticle = $articleModel->deleteArticle($idOfArticle, $id_user);
                FlashBag::addFlash("Article supprimé !", 'success');
            }   

            $this->redirect('myarticles');
        }
        else
        {
            $this->redirect('accessRefused');
        }
    }

    // public function uploadFile()
    // {
    //     if(UserSession::administrator() || UserSession::author())
    //     {
    //         if(!empty($_POST))
    //         {
    //             $file = $_FILES['file'];
    //             $name = trim(htmlspecialchars($_POST['name']));
    //             $content = trim(htmlspecialchars($_POST['content']));

    //             if(!$name)
    //             {
    //                 FlashBag::addFlash("Le champ nom est vide", 'error');
    //             }

    //             if (!$content)
    //             {
    //                 FlashBag::addFlash("Le champ de description est vide", 'error');
    //             }

    //             if(strlen($content) > 200)
    //             {
    //                 FlashBag::addFlash("Le champ de description ne doit pas contenir plus de 200 caractères", 'error');
    //             }

    //             if(!$file['name'])
    //             {
    //                 FlashBag::addFlash('La zone de fichier est vide', 'error');
    //             }

    //             if($file['error'] > 0)
    //             {
    //                 FlashBag::addFlash('Une erreur est survenue lors du chargement du fichier.', 'error');
    //             }

    //             if($file['size'] > 8000000)
    //             {
    //                 FlashBag::addFlash("Le fichier est trop volumineux, au-delà de 8 Mo", 'error');
    //             }


    //             $fileName = $file['name'];
    //             $fileExtension = "." . strtolower(substr(strrchr($fileName, "."), 1));

    //             $validExtension = ['.pdf', '.doc', '.docx', '.odt', '.txt'];

    //             if(!in_array($fileExtension, $validExtension))
    //             {
    //                 FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
    //             }

                        
    //             if (!(FlashBag::hasMessages('error')))
    //             {
                    
    //                 FlashBag::addFlash("Votre fichier a bien été enregistré.");

    //                 $uniqueName = md5(uniqid(rand(), true));
    //                 $fileName = $uniqueName . $fileExtension;
    //             }
                
    //         }

    //     }
    //     else
    //     {
    //         $this->redirect('accessRefused');
    //     }
    //     return $this->render('uploadfile', [
    //         'name' => $name??'',
    //         'content' => $content??''
    //     ]);
    // }
}