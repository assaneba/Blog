<?php


namespace Model\Manager;

use Model\Post;

class PostManager extends Manager
{

    public function getOne($idpost) {
        //Get a post by his id
        $db = $this->connectToDB();
        $q = $db->prepare('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, 
                                    user_iduser FROM post WHERE idpost=:id');
        $q->execute([':id' => $idpost]);
        $inputs = $q->fetchObject();
        if($inputs) {
            return new Post($inputs);
        }
        else {
            return false;
        }
    }

    public function getAllPublic() {
        //Get all public posts
        $db = $this->connectToDB();
        $q = $db->query('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, 
                                    user_iduser FROM post WHERE post_public=1 ORDER BY date_creation DESC');
        return $q->fetchAll();
    }

    public function addPost($title, $idCategory, $lead, $content) {
        $db = $this->connectToDB();
        $insertInPost = $db->prepare('INSERT INTO post (title, lead, content, date_creation, post_public, date_planned,
                                        user_iduser) VALUES (?, ?, ?, NOW(), 1, NULL, 1)');
        $insertInPost->bindParam(1, $title);
        $insertInPost->bindParam(2, $lead);
        $insertInPost->bindParam(3, $content);
        if($insertInPost->execute()){
            $idPost = $db->lastInsertId() ;
            $insertInCategoryHasPost = $db->prepare('INSERT INTO category_has_post (category_idcategory,
                                                                post_idpost) VALUES (?, ?)');
            $insertInCategoryHasPost->bindParam(1, $idCategory);
            $insertInCategoryHasPost->bindParam(2, $idPost);
            if($insertInCategoryHasPost->execute()){
                //echo 'Super les deux requetes ont été bien enregistrées !';
                return true;
            }
        }
    }
}
