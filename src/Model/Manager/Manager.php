<?php


namespace Manager;

use Exception;
use PDO;

// On inclut myconfig.php qui contient les données d'accès ç la base de données

require_once __DIR__.'/../../../config/myconfig.php';

abstract class Manager
{
    protected $db;

    //Fonction de connexion à la base de données qui sera héritée par les classes Manager

    public function connectToDB()
    {
        try {
            $this->db = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PWD);
            //echo 'good !';
            return $this->db;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}

//$test = new Manager();
//var_dump($test->connectToDB());