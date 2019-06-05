<?php


namespace Manager;

require_once __DIR__.'/../../../config/dbconfig.php';

use Model\Post;

/*require_once 'Manager.php';
require_once '../Post.php';*/

class PostManager extends Manager
{

    public function getOne($idpost)
    {
        //Get a post
        $db = $this->connectToDB();
        $q = $db->prepare('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, user_iduser FROM post WHERE idpost=:id');
        $q->execute([':id' => $idpost]);
        //return new Post($q->fetch(PDO::FETCH_ASSOC));
        $inputs = $q->fetchObject();
        return new Post($inputs);
        //return $q = $q->fetch();
    }

    public function getAllPublic()
    {
        //Get all public posts
        $db = $this->connectToDB();
        $q = $db->query('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, user_iduser FROM post WHERE post_public=1');
        //$q->execute([':id' => $idpost]);
        //return new Post($q->fetch(PDO::FETCH_ASSOC));
        return $q->fetchAll();
    }
}

//$man = new PostManager();

//$test = $man->connectToDB();
//var_dump($man->getOne(1));

//$data = $man->getOne(1);

//var_dump($data);
//$post = new Post($data);

//echo $data->getContent();

//var_dump($data);
//echo $data->title;
//var_dump($data['title']);
//$i = 1;

/*foreach ($data as $value)
{
    echo  $value .'<br>';
    //$i++;
}*/