<?php


namespace App\Repository;


class TypeRepository extends AbstractRepository
{
    public function find($id)
    {
        $query = $this->DBConnexion->prepare("SELECT id, label FROM shop_type WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);

        return $query->fetch();
    }

    public function findAll()
    {
        $query = $this->DBConnexion->prepare("SELECT id, label FROM shop_type");
        $query->execute();
        return $query->fetchAll();
    }

    public function findOneBy($criteria)
    {
        // TODO: Implement findOneBy() method.
    }

    public function findAllBy($criteria)
    {
        // TODO: Implement findAllBy() method.
    }

    public function delete($id)
    {
        $query = $this->DBConnexion->prepare("DELETE FROM shop_type WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
    }

    #mettre à jour les données de la base
    #Si $id est null => insert, sinon update
    public function update($id, $object)
    {
        $query = null;

        $params = [
            'label' => $object['label'],
        ];

        if (isset($id)) {
            $query = $this->DBConnexion->prepare("UPDATE shop_type SET label=:labele WHERE id=:id");
            $params['id'] = $id;
        }
        else {
            $query = $this->DBConnexion->prepare("INSERT INTO shop_type (label) VALUES (:label)");
        }

        $query->execute($params);

        return isset($id) ? $id : $this->DBConnexion->lastInsertId();
    }
}
