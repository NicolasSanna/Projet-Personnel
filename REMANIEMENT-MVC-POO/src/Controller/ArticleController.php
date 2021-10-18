<?php

namespace App\Controller;

use App\Framework\AbstractController;
use App\Model\ArticleModel;
use App\Framework\FlashBag;
use App\Model\CommentModel;
use App\Framework\UserSession;

class ArticleController extends AbstractController
{
    public function index()
    {
        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id'])) 
        {
            $idOfArticle = (int) $_GET['id'];

            $articleModel = new ArticleModel();

            $article = $articleModel->getOneArticle($idOfArticle);

            $commentModel = new CommentModel();
            $comments = $commentModel->getAllcomments($idOfArticle);

            if(!empty($article['id']))
            {
                return $this->render('article', [
                    'article' => $article,
                    'comments' => $comments
                ]);
            }
            else
            {
                FlashBag::addFlash('Aucun article ne correspond à cet identifiant.');
                return $this->redirect('forum');
            }
        }
    }

    public function addComment()
    {
        if (!UserSession::author())
        {
            $this->redirect('accessRefused');
        }
        if (array_key_exists('id', $_GET) || $_GET['id'] || ctype_digit($_GET['id']))
        {
            $idOfArticle = (int) $_GET['id'];
            
            $articleModel = new ArticleModel();
            $article = $articleModel->getOneArticle($idOfArticle);

            if(!empty($_POST))
            {
                $comment = trim(htmlspecialchars($_POST['comment']));
                $user_id = UserSession::getId();

                if(!$comment)
                {
                    FlashBag::addFlash("Le champ commentaire est vide", "error");
                }
                else
                {
                    $commentModel = new CommentModel();
                    $insertComment = $commentModel->addComment($comment, $user_id, $idOfArticle);
                    FlashBag::addFlash("Votre commentaire a bien été ajouté !", "error");

                }
            }
            header('Location:' . buildUrl('article', ['id' => $idOfArticle]));
        }
    }
}