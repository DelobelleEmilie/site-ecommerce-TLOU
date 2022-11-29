<?php


namespace App\Core;


use Exception;
use PDO;

class Database
{
    const CONFIG = [
        'dbserver'      => 'localhost',
        'dblogin'       => 'login8060',
        'dbpassword'    => 'ozlowUrCCuOTNPU',
        'dbname'        => 'dblogin8060'
    ];

//    const CONFIG = [
//        'dbserver'      => 'shop-database',
//        'dblogin'       => 'user',
//        'dbpassword'    => 'password',
//        'dbname'        => 'test'
//    ];

    public function getConnection() {
        try{
            $pdo = new PDO('mysql:host='.$this::CONFIG['dbserver'].';dbname='.$this::CONFIG['dbname'], $this::CONFIG['dblogin'], $this::CONFIG['dbpassword']);
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
        return $pdo;
    }
}