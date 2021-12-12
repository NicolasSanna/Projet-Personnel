<?php

namespace App\Model;

use App\Framework\AbstractModel;

class MessageModel extends AbstractModel
{
    public function getAllUsers ()
    {
        $sql = 'CALL SP_GetAllUsersMessageSelect()';

        $users = $this->database->getAllResults($sql);
        return $users;
    }

    public function sendMessage(string $id_message, int $fromUserId, int $toUserId, string $subject, string $content)
    {
        $sql = 'CALL SP_MessageInsert(?, ?, ?, ?, ?)';

        $insertMessage = $this->database->executeQuery($sql, [$id_message, $fromUserId, $toUserId, $subject, $content]);
    }

    public function inBox (int $userId)
    {
        $sql = 'CALL SP_InboxSelect(?)';

        $myMessages = $this->database->getAllResults($sql, [$userId]);

        return $myMessages;
    }

    public function sendBox(int $userId)
    {
        $sql = 'CALL SP_SendBoxSelect(?)';

        $myMessagesSend = $this->database->getAllResults($sql, [$userId]);

        return $myMessagesSend;
    }

    public function messageRead (string $messageId)
    {
        $sql = 'CALL SP_MessageSelect(?)';

        $message = $this->database->getOneResult($sql, [$messageId]);

        return $message;
    }

    public function moveToTrashFromUserMessage(string $messageId)
    {
        $sql = 'CALL SP_MessageFromUserTrashboxUpdate(?)';

        $moveToTrash = $this->database->executeQuery($sql, [$messageId]);
    }

    public function moveToTrashToUserMessage(string $messageId)
    {
        $sql = 'CALL SP_MessageToUserTrashboxUpdate(?)';

        $moveToTrash = $this->database->executeQuery($sql, [$messageId]);
    }
}