<?php


namespace Controller;
use Manager;
use Model\Post;

class HomeController
{
    /**
     * Home page controller.
     *
     * @param
     */

    public function index() {
        echo 'Page Accueil' ;
    }

    public function blog()
    {
        //echo '<h1> Page accueil du blog </h1>';
        $post = new Manager\PostManager();
        $allPost = $post->getAllPublic();
        require_once __DIR__. '/../../views/test-view.php';
        //var_dump($allPost);
        //echo $allPost->getTitle().' '. $allPost->getContent();

    }
}