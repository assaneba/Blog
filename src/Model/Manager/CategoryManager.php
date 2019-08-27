<?php

namespace Model\Manager;

class CategoryManager extends Manager
{
    public function getCategories()
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT idcategory, name FROM category');
        $req->execute();
        return $req->fetchAll();

    }

    public function getCategory($idPost)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT category_idcategory FROM category_has_post INNER JOIN post ON 
                                        post.idpost = category_has_post.post_idpost WHERE idpost = ?');
        $req->bindParam(1, $idPost);
        $req->execute();
        if($idCategory = $req->fetchColumn()) {
            //echo 'Requete pour récupérer l'id de la catégorie du post';
            $getCategory = $dbc->prepare('SELECT idcategory, name FROM category WHERE idcategory = :idCategory');
            $getCategory->execute(array(':idCategory' => $idCategory));
            return $getCategory->fetchObject();
        }

    }

    public function addCategory($nameCat)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('INSERT INTO category (name) VALUES (?)');
        $req->bindParam(1, $nameCat);
        $req->execute();
    }

    public function editCategory($idcategory, $nameCat)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('UPDATE category SET name = ? WHERE idcategory = ?');
        $req->bindParam(1, $nameCat);
        $req->bindParam(2, $idcategory);
        if($req->execute())
            return true;
    }

    public function deleteCategory($idCategory)
    {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('DELETE FROM category WHERE idcategory = :idCategory');
        $req->execute([':idCategory' => $idCategory]);
        return $req;
    }

}