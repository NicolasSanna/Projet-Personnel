<?php

namespace App\Controller;

use App\Framework\Get;
use App\Framework\Post;
use App\Framework\FlashBag;
use App\Model\ArticleModel;
use App\Model\CommentModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class ArticleController extends AbstractController
{
    public function index()
    {
        if (Get::existsDigit('id')) 
        {
            $idOfArticle = (int) Get::key('id');
            $articleModel = new ArticleModel();
            $article = $articleModel->getOneArticle($idOfArticle);
            $pageTitle = $article['title'];
            
            $commentModel = new CommentModel();
            $comments = $commentModel->getAllcomments($idOfArticle);

            if(empty($article['id']))
            {
                FlashBag::addFlash('Aucun article ne correspond à cet identifiant.', 'error');
                $this->redirect('forum');
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
            if(!empty($_POST))
            {
                $idOfArticle = (int) Post::verifyContent('article-id');
                $comment = Post::verifyContent('comment');
                $user_id = UserSession::getId();

                $articleModel = new ArticleModel();
                $article = $articleModel->getOneArticle($idOfArticle);

                if(!$article)
                {
                    FlashBag::addFlash("Aucun article trouvé.", 'error');
                    $this->redirect('forum');
                }

                if(!$comment)
                {
                    FlashBag::addFlash("Le champ commentaire est vide", "error");
                }
                
                if (!(FlashBag::hasMessages('error')))
                {
                    $commentModel = new CommentModel();
                    $insertComment = $commentModel->addComment($comment, $user_id, $idOfArticle);
                    FlashBag::addFlash("Votre commentaire a bien été pris en compte. Il sera visible prochainement.", "success");
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