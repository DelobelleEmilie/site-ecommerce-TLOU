<?php


namespace App\Repository;


use App\Controller\ErrorController;
use App\Core\Database;

abstract class AbstractRepository
{
    protected $DBConnexion;

    public function __construct()
    {
        // Tous les repositories ont accès à la base de données
        $database = new Database();
        $this->DBConnexion = $database->getConnection();

        if (is_string($this->DBConnexion)) {
            $controller = new ErrorController();
            $controller->show($this->DBConnexion);
            die();
        }
    }

    public abstract function find($id);

    public abstract function findAll();

    public abstract function findOneBy($criteria);

    public abstract function findAllBy($criteria);

    public abstract function delete($id);

    public abstract function update($id, $object);
}