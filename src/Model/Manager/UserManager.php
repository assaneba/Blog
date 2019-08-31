<?php

namespace Model\Manager;

use Model\User;

class UserManager extends Manager
{

    public function checkUser($email, $password)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT iduser, login, password, first_name, last_name, email, user_role FROM user
                                        WHERE email=:email');
        $req->execute(array(':email' => $email));
        $inputs = $req->fetchObject();
        //var_dump($inputs);die;
        if($inputs){
            //echo 'User Existe';
            $user = new User($inputs);
            if(password_verify($password, $user->getPassword()))

                return $user;
        }

    }

    /**
     * Check if an email exists in the database
     * @return true if the email already exists in the database
     */
    public function checkEmail($email)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT * FROM user WHERE email=:email');
        $req->execute(array('email' => $email));
        if($req->fetchColumn()) {
            //echo 'Erreur l\'email est déjà utilisé <br>';
            return true;
        }
    }

    /**
     * Check if an email exists in the database
     * @return true if the email already exists in the database
     */
    public function checkLogin($login)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT * FROM user WHERE login=:login');
        $req->execute(array('login' => $login));
        if ($req->fetchColumn()) {
            //echo 'Erreur l\'email est déjà utilisé <br>';
            return true;
        }
    }

    //public function addUser($login, $password, $firstName, $lastName, $email)
    public function addUser(array $newUserData)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare("INSERT INTO user (login, password, first_name, last_name, email, user_role)
                                        VALUES (:login, :password, :first_name, :last_name, :email, 'ROLE_USER')");
        $result = $req->execute(array(
            'login' => $newUserData['pseudo'],
            'password' => $newUserData['password'],
            'first_name' => $newUserData['firstName'],
            'last_name' => $newUserData['lastName'],
            'email' => $newUserData['email']
        ));
        //var_dump($newUserData);die;
        return $result;
    }

    public function getUsers()
    {
        $dbc = $this->connectToDB();
        $req = $dbc->query('SELECT iduser, login, password, first_name, last_name, email, user_role  FROM user');

        return $req->fetchAll();
    }

    public function getUserbyId($idUser)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT iduser, login, password, first_name, last_name, email, user_role  FROM user 
                                        WHERE iduser = :idUser');
        $req->execute(array(':idUser' => $idUser));

        return $req->fetchObject();
    }

    public function updateUser($iduser, $login, $first_name, $last_name, $email, $user_role)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE user SET login = ?, first_name = ?, last_name = ?, email = ?, user_role = ?
                                        WHERE iduser = ?');
        $req->bindParam(1, $login);
        $req->bindParam(2, $first_name);
        $req->bindParam(3, $last_name);
        $req->bindParam(4, $email);
        $req->bindParam(5, $user_role);
        $req->bindParam(6, $iduser);

        return $req->execute();
    }

    public function updateUserWithPass($iduser, $login, $password, $first_name, $last_name, $email, $user_role)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE user SET login = ?, first_name = ?, last_name = ?, email = ?, user_role = ?,
                                        password = ? WHERE iduser = ?');
        $req->bindParam(1, $login);
        $req->bindParam(2, $first_name);
        $req->bindParam(3, $last_name);
        $req->bindParam(4, $email);
        $req->bindParam(5, $user_role);
        $req->bindParam(6, $password);
        $req->bindParam(7, $iduser);

        return $req->execute();
    }

    public function deleteUser($idUser)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('DELETE FROM user WHERE iduser = :idUser');

        return $req->execute([':idUser' => $idUser]);
    }

}