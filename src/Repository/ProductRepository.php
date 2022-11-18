<?php


namespace App\Repository;


class ProductRepository extends AbstractRepository
{
    public function find($id)
    {
        $query = $this->DBConnexion->prepare("SELECT id, label FROM shop_product WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);

        return $query->fetch();
    }

    public function findAll()
    {
        $query = $this->DBConnexion->prepare("SELECT id, label FROM shop_product");
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
        $query = $this->DBConnexion->prepare("DELETE FROM shop_product WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
    }

    public function update($id, $object)
    {
        // TODO: Implement update() method.
    }
}