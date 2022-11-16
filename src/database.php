<?php

function getConnection($config) {
try{ 
    $pdo = new PDO('mysql:host='.$config['dbserver'].';dbname='.$config['dbname'], $config['login'], $config['dbpassword']);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(Exception $e)
{
    return $e->getMessage();
}
return $pdo;
}

