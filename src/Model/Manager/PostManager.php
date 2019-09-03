<?php

namespace Model\Manager;

use Model\Post;

class PostManager extends Manager
{

    public function getOne(int $idpost)
    {
        //Get a post by his id
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, 
                                        login FROM post INNER JOIN user ON user.iduser = post.user_iduser WHERE idpost=:id');
        $req->execute([':id' => $idpost]);
        $inputs = $req->fetchObject();
        if($inputs) {
            return new Post($inputs);
        }

    }

    /**
     * Get all public posts wich are not planned ones
     * @return array
     */
    public function getAllPublic()
    {
        //Get all public posts
        $dbc = $this->connectToDB();
        $req = $dbc->query('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, 
                                    user_iduser FROM post WHERE post_public=1 AND date_creation <= NOW() ORDER BY date_creation DESC');

        return $req->fetchAll();
    }

    /**
     * Get all public posts wich are not planned ones
     * @return array
     */
    public function getAllPosts()
    {
        //Get all public posts
        $dbc = $this->connectToDB();
        $req = $dbc->query('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, 
                                    user_iduser FROM post WHERE post_public=1 ORDER BY date_creation DESC');

        return $req->fetchAll();
    }

    public function addPost(array $post)
    {
        $dbc = $this->connectToDB();
        $insertInPost = $dbc->prepare('INSERT INTO post (title, lead, content, date_creation, post_public, date_planned,
                                        user_iduser) VALUES (?, ?, ?, ?, 1, NULL, 1)');
        $insertInPost->bindParam(1, $post['title']);
        $insertInPost->bindParam(2, $post['lead']);
        $insertInPost->bindParam(3, $post['content']);
        $insertInPost->bindParam(4,  $post['publicationDate']);
        if($insertInPost->execute()){
            $idPost = $dbc->lastInsertId() ;
            $insertInCatHasPost = $dbc->prepare('INSERT INTO category_has_post (category_idcategory,
                                                                post_idpost) VALUES (?, ?)');
            $insertInCatHasPost->bindParam(1, $post['idCategory']);
            $insertInCatHasPost->bindParam(2, $idPost);
            if($insertInCatHasPost->execute()) {

                return true;
            }
        }
    }

    public function updatePost(array $post)
    {
        $dbc = $this->connectToDB();
        $insertInPost = $dbc->prepare('UPDATE post SET title = ?, lead = ?, content = ?, date_creation = NOW()
                                                WHERE idpost = ?');
        $insertInPost->bindParam(1, $post['title']);
        $insertInPost->bindParam(2, $post['lead']);
        $insertInPost->bindParam(3, $post['content']);
        $insertInPost->bindParam(4, $post['idPost']);
        if($insertInPost->execute()){
            //$idPost = $db->lastInsertId() ;
            $insertInCatHasPost = $dbc->prepare('UPDATE category_has_post SET category_idcategory = ?
                                                                 WHERE post_idpost = ? ');
            $insertInCatHasPost->bindParam(1, $post['idCategory']);
            $insertInCatHasPost->bindParam(2, $post['idPost']);
            if($insertInCatHasPost->execute()){

                return true;
            }
        }
    }

    public function deletePost(int $idPost) {
        $dbc = $this->connectToDB();
        $req = $dbc->prepare('DELETE FROM post WHERE idpost = :idPost');
        $req->execute([':idPost' => $idPost]);

        return $req;
    }

}
