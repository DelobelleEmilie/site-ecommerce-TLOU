<?php


namespace App\Repository;


use App\Controller\ErrorController;
use App\Core\Database;

abstract class AbstractRepository
{
    #attribut de la classe
    #Et protected, ça veut dire que les enfants y ont aussi accès
    #les enfants sont tous ce qu'extends de AbstractRepository
    protected $DBConnexion;

    public function __construct()
    {
        // Tous les repositories ont accès à la base de données
        $database = new Database();
        $this->DBConnexion = $database->getConnection();

        if (is_string($this->DBConnexion)) {
            $controller = new ErrorController();
            $controller->show($this->DBConnexion);
        }
    }

    # tous les enfant doivent avoir ses fonctions là
    #Tous les repository doivent avoir find($id), findAll()....

    /**
     * @param $id
     * @return Object Récupère une entité via son id
     * @return mixed
     */
    public abstract function find($id);

    public abstract function findAll();

    public abstract function findOneBy($criteria);

    public abstract function findAllBy($criteria);

    public abstract function delete($id);

    public abstract function update($id, $object);

}