<?php


namespace Model\Manager;


class CategoryManager extends Manager
{
    public function getCategories () {
        $db = $this->connectToDB();
        $req = $db->prepare('SELECT idcategory, name FROM category');
        $req->execute();
        return $req->fetchAll();

    }
}