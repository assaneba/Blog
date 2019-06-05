<?php


namespace Controller;

use Manager\PostManager;
use Model\Post;

class BlogController
{
    public function index()
    {
        echo '<h1> Page accueil du blog </h1>';
        $post = new PostManager();
        $allPost = $post->getAllPublic();
        //require_once __DIR__ . '/../views/test-view.php';
        var_dump($allPost);
        //echo $allPost->getTitle().' '. $allPost->getContent();

    }

    public function article($params)
    {
        echo 'Voir un article '. $params;
    }
}