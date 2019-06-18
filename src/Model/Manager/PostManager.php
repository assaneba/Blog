<?php


namespace Model\Manager;

use Model\Post;

class PostManager extends Manager
{

    public function getOne($idpost) {
        //Get a post by his id
        $db = $this->connectToDB();
        $q = $db->prepare('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, user_iduser FROM post WHERE idpost=:id');
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
        $q = $db->query('SELECT idpost, title, lead, content, date_creation, post_public, date_planned, user_iduser FROM post WHERE post_public=1');
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