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

    public function getCategory($idPost)
    {
        $db = $this->connectToDB();
        $req = $db->prepare('SELECT category_idcategory FROM category_has_post INNER JOIN post ON 
                                        post.idpost = category_has_post.post_idpost WHERE idpost = ?');
        $req->bindParam(1, $idPost);
        $req->execute();
        if($idCategory = $req->fetchColumn()) {
            //echo 'Requete pour récupérer l'id de la catégorie du post';
            $getCategory = $db->prepare('SELECT idcategory, name FROM category WHERE idcategory = :idCategory');
            $getCategory->execute(array(':idCategory' => $idCategory));
            return $getCategory->fetchObject();
        }
        else {
            echo 'Erreur : Article non catégorisée';
        }

    }

}