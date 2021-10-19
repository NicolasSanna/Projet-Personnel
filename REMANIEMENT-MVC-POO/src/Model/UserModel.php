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

    public function getUserById(int $userId)
    {
        $sql = 'CALL SP_GetUserByid(?)';

        return $this->database->getOneResult($sql, [$userId]);
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

    function adminUsers()
    {
        $sql = 'CALL SP_SelectUsersAdmin()';

        return $this->database->getAllResults($sql);
    }

    function deleteUserWithoutArticlesComments(int $userId)
    {
        $sql = 'CALL SP_DeleteUserWithoutArticlesComments(?)';

        return $this->database->getOneResult($sql, [$userId]);
    }

    function deleteUser(int $userId)
    {
        $sql = 'CALL SP_DeleteUser(?)';

        return $this->database->getOneResult($sql, [$userId]);
    }

    function changeGrant(int $userId, int $grantId)
    {
        $sql = 'CALL SP_ChangeGrant(?, ?)';

        return $this->database->getOneResult($sql, [$userId, $grantId]);
    }
}