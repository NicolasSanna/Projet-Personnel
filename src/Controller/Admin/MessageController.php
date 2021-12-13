<?php

namespace App\Controller\Admin;

use App\Framework\FlashBag;
use App\Model\MessageModel;
use App\Framework\UserSession;
use App\Framework\AbstractController;

class MessageController extends AbstractController
{
    public function index()
    {
        if (UserSession::author() || UserSession::administrator())
        {

            $pageTitle = 'Mes Messages';

            $userId = UserSession::getId();

            $messageModel = new MessageModel();
            $messages = $messageModel->inbox($userId);

            return $this->render('admin/message/inbox', [
                'pageTitle' => $pageTitle??'',
                'messages' => $messages
            ]);
        }
        else 
        {
            $this->redirect('accessRefused');
        }
    }

    public function new ()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            $pageTitle = 'Nouveau Message';

            $messageModel = new MessageModel();
            $users = $messageModel->getAllUsers();

            if(!empty($_POST))
            {
                $content = trim(htmlspecialchars($_POST['content']));
                $subject = trim(htmlspecialchars($_POST['subject']));
                $toUser = (int) $_POST['selectUser'];
                $id_user = UserSession::getId();

                if (!$content || !$subject || !$toUser)
                {
                    FlashBag::addFlash("Tous les champs n'ont pas été remplis", 'error');
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    $idMessage = bin2hex(openssl_random_pseudo_bytes(6));

                $messageModel = new MessageModel();
                $insertMessage = $messageModel->sendMessage($idMessage, $id_user, $toUser, $subject, $content);
                }
                
                
            }
        }
        else
        {
            $this->redirect('accessRefused');
        }

        return $this->render('admin/message/new', [
            'users' => $users,
            'pageTitle' => $pageTitle
        ]);
    }

    public function sendbox ()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            $pageTitle = 'Messages envoyés';

            $userId = UserSession::getId();

            $messageModel = new MessageModel();
            $messages = $messageModel->sendbox($userId);



            return $this->render ('admin/message/sendbox', [
                'pageTitle' => $pageTitle, 
                'messages' => $messages
            ]);
        }
        else
        {
            $this->redirect('accessRefused');
        }
    }

    public function message ()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (array_key_exists('id', $_GET) && $_GET['id'])
            {
                $idOfMessage = $_GET['id'];
            }
            else
            {
                $this->redirect('mymessages');
            }

            $messageModel = new MessageModel();
            $users = $messageModel->getAllUsers();


            $id_user = UserSession::getId();

            $messageModel = new MessageModel();
            $message = $messageModel->messageRead($idOfMessage);



            if(!empty($_POST))
            {
                $content = trim(htmlspecialchars($_POST['content']));
                $subject = trim(htmlspecialchars($_POST['subject']));
                $toUser = $_POST['toUser'];
                $id_user = UserSession::getId();

                if (!$content || !$subject || !$toUser)
                {
                    FlashBag::addFlash("Tous les champs n'ont pas été remplis", 'error');
                }

                if (!(FlashBag::hasMessages('error')))
                {
                    $idMessage = bin2hex(openssl_random_pseudo_bytes(6));

                $messageModel = new MessageModel();
                $insertMessage = $messageModel->sendMessage($idMessage, $id_user, $toUser, $subject, $content);
                }               
                
            }

            return $this->render('admin/message/message', [
                'message' => $message,
                'users' => $users
            ]);
        }
        else
        {
            $this->redirect('accessRefused');
        }

  
    }

    public function moveToTrashFromUser ()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (array_key_exists('id', $_GET) && $_GET['id'])
            {
                $idOfMessage = $_GET['id'];
            }
            else
            {
                $this->redirect('mymessages');
            }

            $messageModel = new MessageModel();
            $messageExist = $messageModel->messageRead($idOfMessage);

            if(!$messageExist)
            {
                FlashBag::addFlash("Il n'existe pas de message sous cet identifiant", 'error');
            }

            if ($messageExist['from_user_id'] != UserSession::getId())
            {
                FlashBag::addFlash("Vous ne pouvez pas supprimer un message qui ne vous est pas destiné.", 'error');
            }

            if (!(FlashBag::hasMessages('error')))
            {
                
                $messageModel = new MessageModel();
                $deleteFromUserMessage = $messageModel->moveToTrashFromUserMessage($idOfMessage);
                FlashBag::addFlash('Message Supprimé', 'success');
                
            }
            $this->redirect('mymessages');
        }

        else
        {
            $this->redirect('accessRefused');
        }
    }




    public function moveToTrashToUser ()
    {
        if (UserSession::author() || UserSession::administrator())
        {
            if (array_key_exists('id', $_GET) && $_GET['id'])
            {
                $idOfMessage = $_GET['id'];
            }
            else
            {
                $this->redirect('mymessages');
            }

            $messageModel = new MessageModel();
            $messageExist = $messageModel->messageRead($idOfMessage);

            if(!$messageExist)
            {
                FlashBag::addFlash("Il n'existe pas de message sous cet identifiant", 'error');
            }

            if ($messageExist['to_user_id'] != UserSession::getId())
            {
                FlashBag::addFlash("Vous ne pouvez pas supprimer un message qui ne vous est pas destiné.", 'error');
            }

            if (!(FlashBag::hasMessages('error')))
            {
                
                $messageModel = new MessageModel();
                $deleteFromUserMessage = $messageModel->moveToTrashToUserMessage($idOfMessage);
                FlashBag::addFlash('Message Supprimé', 'success');
                
            }
            $this->redirect('mymessages');

        }

        else
        {
            $this->redirect('accessRefused');
        }
    }

    public function blockUser()
    {

        if (UserSession::author() || UserSession::administrator())
        {
            $messageModel = new MessageModel();
            $users = $messageModel->getAllUsers();

            $pageTitle = "Bloquer un utilisateur";

            if(!empty($_POST))
            {
                $userToBlock = (int) $_POST['selectUser'];
                $id_user = UserSession::getId();

                if($userToBlock == UserSession::getId())
                {
                    FlashBag::addFlash("Vous ne pouvez pas vous bloquer vous-même", 'error');
                }
                
                if (!(FlashBag::hasMessages('error')))
                {
                    $querySP = $messageModel->blockUser($userToBlock, $id_user);
                    FlashBag::addFlash($querySP['message'], 'query');
    
                    $this->redirect('mymessages');
                }
            }
        }


        return $this->render('admin/message/blockuser', [
            'pageTitle' => $pageTitle,
            'users' => $users
        ]);
    }

    public function inBoxAjax()
    {
        $userId = UserSession::getId();

        $messageModel = new MessageModel();
        $messages = $messageModel->inbox($userId);

        foreach ($messages as $index => $message)
        {
            $messages[$index]['readUrl'] = SITE_BASE_URL . buildUrl('message', ['id' => $message['id_message']]);
            $messages[$index]['deleteUrl'] = SITE_BASE_URL . buildUrl('messageTrashToUser', ['id' => $message['id_message']]);
        }

        $results = json_encode($messages);

        echo $results;
    }


    
}