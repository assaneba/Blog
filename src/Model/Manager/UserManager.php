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

}