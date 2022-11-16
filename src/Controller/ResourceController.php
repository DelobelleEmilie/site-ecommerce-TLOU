<?php


namespace App\Controller;

use App\Core\Database;

abstract class ResourceController extends AbstractController
{
    protected $DBConnexion;

    public function __construct($router)
    {
        parent::__construct($router);

        // Tous les controllers de resources ont accès à la base de données
        $database = new Database();
        $this->DBConnexion = $database->getConnection();

        if (is_string($this->DBConnexion)) {
            $controller = new ErrorController($router);
            $controller->show($this->DBConnexion);
            die();
        }
    }
}