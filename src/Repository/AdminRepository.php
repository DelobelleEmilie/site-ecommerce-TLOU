<?php

namespace App\Repository;

function getAllRoles($db)
{
    $query = $db->prepare("SELECT id, label FROM shop_roles");
    $query->execute();
    return $query->fetchAll();
}