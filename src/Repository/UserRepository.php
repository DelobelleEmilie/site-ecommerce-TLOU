<?php


namespace App\Repository;


class UserRepository extends AbstractRepository
{
    public function find($id)
    {
        $query = $this->DBConnexion->prepare("SELECT id,mail,date_naissance,prénom,nom,mot_passe,role,télephone FROM shop_user WHERE id = :id");
        $query->execute([
            'id' => $id,
        ]);

        return $query->fetch();
    }

    public function findAll()
    {
        $query = $this->DBConnexion->prepare("SELECT id,mail,date_naissance,prénom,nom,mot_passe,role,télephone, active FROM shop_user");
        $query->execute();
        return $query->fetchAll();
    }

    #préparer une requete en base pour récupérer un utilisateur via son mail
    public function findOneBy($criteria)
    {
        #début de la requete pour faire un select
        $base = "SELECT id,mail,date_naissance,prénom,nom,mot_passe,role,télephone FROM shop_user WHERE ";
       # stocker le nouveau tableau dans la variable $where
        $where = array_map(
            #La fonction prend un élément, et le transforme en "élément = :élément"
            function ($key) {
                return "$key = :$key";
            },
            #récupère les clefs
            array_keys($criteria)
        );
        # tableau d'éléments du type id = :id ou mail = :mail
        #join prend ces éléments, et les colle ensemble avec " AND "
        #Ce qui donne "id = :id AND mail = :mail"
        #Qu'on rajoute à la requete de base
        $where = join(" AND ", $where);

        #$query Prépare et Exécute une requête SQL
        #prepare la requete sql pour la connexion depuis la base de donnée
        $query = $this->DBConnexion->prepare($base . $where);
        #excuter la base de donnée
        $query->execute($criteria);
    
        $result = $query->fetch();
    
        return gettype($result) !== 'boolean' ? $result : null;
    }

    public function findAllBy($criteria)
    {
        // TODO: Implement findAllBy() method.
    }

    public function delete($id)
    {
        $query = $this->DBConnexion->prepare("DELETE FROM shop_user WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
    }

    #mettre à jour les données de la base
    #Si $id est null => insert, sinon update
    public function update($id, $object)
    {
        # la requete sql est nul
        $query = null;
    #implanter les parametres des données
        $params = [
            'mail' => $object['mail'],
            'date_naissance' => $object['date_naissance'],
            'prenom' => $object['prénom'],
            'nom' => $object['nom'],
            'mot_passe' => $object['mot_passe'],
            'role' => $object['role'],
            'telephone' => $object['télephone']
        ];
        #affiche les info lisible de la variable et renvoie true
        echo print_r($params, true);
        # isset permet de détermine si une variable est déclarée et est différente de null

        if (isset($id)) {
            $query = $this->DBConnexion->prepare("UPDATE shop_user SET mail=:mail,date_naissance=:date_naissance,`prénom`=:prenom,nom=:nom,mot_passe=:mot_passe,role=:role,`télephone`=:telephone WHERE id=:id");
            $params['id'] = $id;
        }
        else {
            $query = $this->DBConnexion->prepare("INSERT INTO shop_user (mail, date_naissance, `prénom`, nom, mot_passe, role, `télephone`) VALUES (:mail, :date_naissance, :prenom, :nom, :mot_passe, :role, :telephone)");
        }

        $query->execute($params);

        return isset($id) ? $id : $this->DBConnexion->lastInsertId();
    }
    #fonction qui verfier les mails et les mdp
public function verify($email, $password)
{
    #si mail ou mdp = 0 alors sa retourne null
    if (!isset($email) || strlen($email) == 0) { return null; }
    if (!isset($password) || strlen($password) == 0) { return null; }
    #prepare les données de la base
    $query = $this->DBConnexion->prepare("SELECT id, mail, mot_passe, prénom, nom, role FROM shop_user WHERE mail=:email");
    #verifier le mail dans la base et excute le script
    $query->execute([
        'email' => $email
    ]);
    #Recuper par défaut la base de données du user
    $user = $query->fetch();

    if (!isset($user))
    {
        return null;
    }
    #si l'user rendre bien le mot de passe sa renvoie user
    if ($user['mot_passe'] == $password) {
        return $user;
    }
    #sinon sa retour donnée null
    return null;
}

    public function toggleActive($id)
    {
        $query = $this->DBConnexion->prepare("SELECT active FROM shop_user WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
        $active = $query->fetch()['active'];

        $query = $this->DBConnexion->prepare("UPDATE shop_user SET active = :active WHERE id = :id");
        $query->execute([
            'id' => $id,
            'active' => $active == 0 ? 1 : 0
        ]);
        return $query->rowCount() > 0;
    }
}