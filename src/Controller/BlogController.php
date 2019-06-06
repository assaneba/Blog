<?php


namespace Controller;

use Manager\PostManager;

class BlogController extends Controller
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

    public function article()
    {
        //echo 'Voir un article '. $params;
        echo $this->twig->render('home.html.twig',
            array(
                'post' => 'component of post'
            )
            );

    }
}