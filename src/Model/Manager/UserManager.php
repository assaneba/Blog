<?php


namespace Model\Manager;

use Model\User;

class UserManager extends Manager
{

    public function getUser($email, $password) {
        $db = $this->connectToDB();
        $req = $db->prepare('SELECT iduser, login, password, first_name, last_name, email, user_role FROM user
                                        WHERE email=:email AND password=:password');
        $req->execute(array(':email' => $email, ':password' => $password));
        $inputs = $req->fetchObject();
        //var_dump($inputs);
        return new User($inputs);
    }

    /**
     * Check if an email exists in the database
     * @return true if the email already exists in the database
     */
    public function checkEmail($email) {
        $db = $this->connectToDB();
        $req = $db->prepare('SELECT * FROM user WHERE email=:email');
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
        $db = $this->connectToDB();
        $req = $db->prepare('SELECT * FROM user WHERE login=:login');
        $req->execute(array('login' => $login));
        if ($req->fetchColumn()) {
            //echo 'Erreur l\'email est déjà utilisé <br>';
            return true;
        }

    }

    public function addUser($login, $password, $firstName, $lastName, $email) {
        $db = $this->connectToDB();
        $req = $db->prepare("INSERT INTO user (login, password, first_name, last_name, email, user_role)
                                        VALUES (:login, :password, :first_name, :last_name, :email, 'ROLE_USER')");
        $req->execute(array(
            'login' => $login,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email
        ));

    }

}