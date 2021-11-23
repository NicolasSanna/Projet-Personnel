<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\CommentModel;

class ArticleController extends AbstractController
{
    public function index()
    {
        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id'])) 
        {
            $idOfArticle = (int) $_GET['id'];
            $articleModel = new ArticleModel();
            $article = $articleModel->getOneArticle($idOfArticle);
            $pageTitle = $article['title'];

            $commentModel = new CommentModel();
            $comments = $commentModel->getAllcomments($idOfArticle);

            if(empty($article['id']))
            {
                FlashBag::addFlash('Aucun article ne correspond à cet identifiant.', 'error');
                return $this->redirect('forum');
            }
        }
        else
        {
            $this->redirect('forum');
        }

        return $this->render('article', [
            'article' => $article??'',
            'comments' => $comments??'',
            'pageTitle' => $pageTitle??''
        ]);
    }

    public function addComment()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
            {
                $idOfArticle = (int) $_GET['id'];
                
                $articleModel = new ArticleModel();
                $article = $articleModel->getOneArticle($idOfArticle);

                if(!$article)
                {
                    FlashBag::addFlash("Aucun article trouvé", 'error');
                    $this->redirect('forum');
                }
    
                if(!empty($_POST))
                {
                    $comment = trim(nl2br(htmlspecialchars($_POST['comment'])));
                    $user_id = UserSession::getId();
    
                    if(!$comment)
                    {
                        FlashBag::addFlash("Le champ commentaire est vide", "error");
                    }
                    else
                    {
                        $commentModel = new CommentModel();
                        $insertComment = $commentModel->addComment($comment, $user_id, $idOfArticle);
                        FlashBag::addFlash("Votre commentaire a bien été pris en compte. Il sera visible prochainement.", "success");
                    }
                }
                $this->redirect('article', ['id' => $idOfArticle]);
            }
            else
            {
                $this->redirect('forum');
            }
        }
        else
        {
            $this->redirect('accessRefused');
        }
    }
}