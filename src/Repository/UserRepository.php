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
        $query = $this->DBConnexion->prepare("SELECT id,mail,date_naissance,prénom,nom,mot_passe,role,télephone FROM shop_user");
        $query->execute();
        return $query->fetchAll();
    }

    public function findOneBy($criteria)
    {
        $base = "SELECT id,mail,date_naissance,prénom,nom,mot_passe,role,télephone FROM shop_user WHERE ";
        $where = array_map(
            function ($key) {
                return "$key = :$key";
            },
            array_keys($criteria)
        );
        $where = join(" AND ", $where);

        $query = $this->DBConnexion->prepare($base . $where);
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
        $query = null;

        $params = [
            'mail' => $object['mail'],
            'date_naissance' => $object['date_naissance'],
            'prenom' => $object['prénom'],
            'nom' => $object['nom'],
            'mot_passe' => $object['mot_passe'],
            'role' => $object['role'],
            'telephone' => $object['télephone']
        ];

        echo print_r($params, true);

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
public function verify($email, $password)
{
    if (!isset($email) || strlen($email) == 0) { return null; }
    if (!isset($password) || strlen($password) == 0) { return null; }

    $query = $this->DBConnexion->prepare("SELECT id, mail, mot_passe, prénom, nom, role FROM shop_user WHERE mail=:email");
    $query->execute([
        'email' => $email
    ]);
    $user = $query->fetch();

    if (!isset($user))
    {
        return null;
    }

    if ($user['mot_passe'] == $password) {
        return $user;
    }

    return null;
}
}