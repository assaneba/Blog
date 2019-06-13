<?php


namespace Model\Manager;

use Exception;
use PDO;

abstract class Manager
{
    protected $db;

    /**
     * @return PDO
     * Function for database connection which uses data in config/myconfig
     */
    public function connectToDB() {
        try {
            $this->db = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PWD);
            //echo 'good !';
            return $this->db;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}
