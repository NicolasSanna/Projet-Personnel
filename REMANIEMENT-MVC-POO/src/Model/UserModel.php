<?php

namespace App\Model;

use App\Framework\AbstractModel;

class UserModel extends AbstractModel
{
    function createUser($firstname, $lastname, $pseudo, $email, $password)
    {
        $sql = 'CALL SP_Inscription(?, ?, ?, ?, ?)';

        $createUser = $this->database->getOneResult($sql, [$firstname, $lastname, $pseudo, $email, $password]);

        return $createUser;
    }
}