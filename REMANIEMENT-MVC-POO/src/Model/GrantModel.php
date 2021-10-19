<?php

namespace App\Model;

use App\Framework\AbstractModel;

class GrantModel extends AbstractModel
{
    function getAllGrants()
    {
        $sql = 'CALL SP_GetAllGrants ()';

        $allGrants = $this->database->getAllResults($sql);

        return $allGrants;
    }
}