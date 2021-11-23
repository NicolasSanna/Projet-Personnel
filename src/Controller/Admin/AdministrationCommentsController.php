<?php

namespace App\Controller\Admin;

use App\Framework\AbstractController;
use App\Framework\FlashBag;
use App\Framework\UserSession;
use App\Model\CommentModel;

class AdministrationCommentsController extends AbstractController
{
    public function adminCommentsNotApprouved()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        $pageTitle = 'Modérer les commentaires';

        $commentModel = new CommentModel();
        $commentsNotApprouved = $commentModel->getAllCommentsNotApprouved();

        return $this->render('admin/admincomments', [
            'commentsNotApprouved' => $commentsNotApprouved??'',
            'pageTitle' => $pageTitle
        ]);
    }

    public function commentApprouved()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {
            $idOfComment = $_GET['id'];

            $commentModel = new CommentModel();
            $checkIfCommentExist = $commentModel->getOneComment($idOfComment);

            if(!$checkIfCommentExist)
            {
                FlashBag::addFlash("Ce commentaire n'existe pas", 'error');
            }
            else
            {
                $commentApprouved = $commentModel->commentApprouved($idOfComment);
                FlashBag::addFlash("Ce commentaire a été approuvé", 'success');
            }
            $this->redirect('commentsAdministration');
        }
        else
        {
            $this->redirect('administration');
        }
    }

    public function commentRefused()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        if (array_key_exists('id', $_GET) && $_GET['id'] && ctype_digit($_GET['id']))
        {

            $idOfComment = $_GET['id'];

            $commentModel = new CommentModel();
            $checkIfCommentExist = $commentModel->getOneComment($idOfComment);

            if(!$checkIfCommentExist)
            {
                $commentApprouved = $commentModel->commentApprouved($idOfComment);
                FlashBag::addFlash("Ce commentaire n'existe pas.", 'error');
                
            }
            else
            {
                $deleteComment = $commentModel->commentDelete($idOfComment);
                FlashBag::addFlash("Ce commentaire a été supprimé.", 'success');
                
            }
            $this->redirect('commentsAdministration');
        }
        else
        {
            $this->redirect('administration');
        }

    }

    public function AllCommentsApprouved()
    {
        if(!UserSession::administrator())
        {
            $this->redirect('accessRefused');
        }

        $commentModel = new CommentModel();
        $allCommentsApprouved = $commentModel->AllCommentsApprouved();
        FlashBag::addFlash("Tous les commentaires ont été approuvés", 'success');
        $this->redirect('commentsAdministration');
    }
}

