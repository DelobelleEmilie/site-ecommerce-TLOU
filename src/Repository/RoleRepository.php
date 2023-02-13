<?php

use \App\Repository\AbstractRepository;

class RoleRepository extends AbstractRepository
{
    public  function getAllRoles($db)
    {
        $query = $db->prepare("SELECT id, label FROM shop_roles");
        $query->execute();
        return $query->fetchAll();
    }
}