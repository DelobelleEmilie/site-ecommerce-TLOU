<?php


namespace App\Repository;


#categoryRepository hérite de AbstractRepository
class CategoryRepository extends AbstractRepository
{
    #définit les fonctions obligatoires
  
    public function find($id)
    {
        $query = $this->DBConnexion->prepare("SELECT id, label FROM shop_category WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);

        return $query->fetch();
    }

      #find($id) pour trouver une catégorie par son id
    public function findAll()
    {
        $query = $this->DBConnexion->prepare("SELECT id, label FROM shop_category");
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

    #supprimer une catégorie
    public function delete($id)
    {
        $query = $this->DBConnexion->prepare("DELETE FROM shop_category WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
    }
    public function update($id, $object)
    {
        $query = null;
    
        $params = [
            'label' => $object['label'],
        ];
    
    
        if (isset($id)) {
            $query = $this->DBConnexion->prepare("UPDATE shop_category SET label=:label WHERE id=:id");
            $params['id'] = $id;
        }
        else {
            $query = $this->DBConnexion->prepare("INSERT INTO shop_category (label) VALUES (:label)");
        }
    
        $query->execute($params);
    
        return isset($id) ? $id : $this->DBConnexion->lastInsertId();
    }
}