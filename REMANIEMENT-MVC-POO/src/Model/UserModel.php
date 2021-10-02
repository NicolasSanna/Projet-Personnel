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

    public function getUserByEmail(string $email)
    {
        $sql = 'CALL SP_GetUserByEmail(?)';

        return $this->database->getOneResult($sql, [$email]);
    }

    public function checkCredentials(string $email, string $password)
    {

        $user = $this->getUserByEmail($email);

        if (!$user) 
        {
            return false;

        }

        if (!password_verify($password, $user['password']))
        {
            return false;

        }

        return $user;

    }
}