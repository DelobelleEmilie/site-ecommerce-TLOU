<?php


namespace App\Repository;


class ProductRepository extends AbstractRepository
{
    public function find($id)
    {
        $query = $this->DBConnexion->prepare("SELECT id, label, description, price, idCategory, idType FROM shop_product WHERE id = :id");
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

    #mettre à jour les données de la base
    #Si $id est null => insert, sinon update
    public function update($id, $object)
    {
        $query = null;

        $params = [
            'label' => $object['label'],
            'description' => $object['description'],
            'price' => $object['price'],
            'idCategory' => $object['category'],
            'idType' => $object['type']
        ];

        if (isset($id)) {
            $query = $this->DBConnexion->prepare("UPDATE shop_product SET label=:label, description=:description, price=:price, idCategory=:idCategory, idType=:idType WHERE id=:id");
            $params['id'] = $id;
        }
        else {
            $query = $this->DBConnexion->prepare("INSERT INTO shop_product (label, description, price, idCategory, idType) VALUES (:label, :description, :price, :idCategory, :idType)");
        }

        $query->execute($params);

        return isset($id) ? $id : $this->DBConnexion->lastInsertId();
    }
}