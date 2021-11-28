<?php

namespace App\Model;

use App\Framework\AbstractModel;

class UserModel extends AbstractModel
{
    function createUser(string $firstname, string $lastname, string $pseudo, string $email, string $password)
    {
        $sql = 'CALL SP_InscriptionInsert(?, ?, ?, ?, ?)';

        $createUser = $this->database->getOneResult($sql, [$firstname, $lastname, $pseudo, $email, $password]);

        return $createUser;
    }

    public function getUserById(int $userId)
    {
        $sql = 'CALL SP_UserByIdSelect(?)';

        return $this->database->getOneResult($sql, [$userId]);
    }

    public function getUserByEmail(string $email)
    {
        $sql = 'CALL SP_UserByEmailSelect(?)';

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
        $sql = 'CALL SP_UsersAdminSelect()';

        return $this->database->getAllResults($sql);
    }

    function deleteUserWithoutArticlesComments(int $userId)
    {
        $sql = 'CALL SP_UserWithoutArticlesCommentsDelete(?)';

        return $this->database->getOneResult($sql, [$userId]);
    }

    function deleteUser(int $userId)
    {
        $sql = 'CALL SP_UserDelete(?)';

        return $this->database->getOneResult($sql, [$userId]);
    }

    function changeGrant(int $userId, int $grantId)
    {
        $sql = 'CALL SP_GrantUpdate(?, ?)';

        return $this->database->getOneResult($sql, [$userId, $grantId]);
    }
}