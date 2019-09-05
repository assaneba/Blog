<?php

namespace Model\Manager;

use Model\User;

class UserManager extends Manager
{

    public function checkUser(string $email, string $password)
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
    public function checkEmail(string $email)
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
    public function checkLogin(string $login)
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

    public function getUserbyId(int $idUser)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT iduser, login, password, first_name, last_name, email, user_role  FROM user 
                                        WHERE iduser = :idUser');
        $req->execute(array(':idUser' => $idUser));

        return $req->fetchObject();
    }

    public function updateUser(int $idUser, array $userData)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE user SET login = ?, first_name = ?, last_name = ?, email = ?, user_role = ?
                                        WHERE iduser = ?');
        $req->bindParam(1, $userData['login']);
        $req->bindParam(2, $userData['firstName']);
        $req->bindParam(3, $userData['lastName']);
        $req->bindParam(4, $userData['email']);
        $req->bindParam(5, $userData['userRole']);
        $req->bindParam(6, $idUser);

        return $req->execute();
    }

    public function updateUserWithPass(int $idUser, array $userData)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE user SET login = ?, first_name = ?, last_name = ?, email = ?, user_role = ?,
                                        password = ? WHERE iduser = ?');
        $req->bindParam(1, $userData['login']);
        $req->bindParam(2, $userData['firstName']);
        $req->bindParam(3, $userData['lastName']);
        $req->bindParam(4, $userData['email']);
        $req->bindParam(5, $userData['userRole']);
        $req->bindParam(6, $userData['password1']);
        $req->bindParam(7, $idUser);

        return $req->execute();
    }

    public function deleteUser(int $idUser)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('DELETE FROM user WHERE iduser = :idUser');

        return $req->execute([':idUser' => $idUser]);
    }

}