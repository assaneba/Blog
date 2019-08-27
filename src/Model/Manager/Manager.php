<?php

namespace Model\Manager;

use PDO;

abstract class Manager
{
    protected $dbc;

    /**
     * @return PDO
     * Function for database connection which uses data in config/myconfig
     */
    public function connectToDB()
    {
            $this->dbc = new PDO('mysql:host=' . HOST_NAME . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PWD);

            return $this->dbc;
    }

}
