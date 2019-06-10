<?php


namespace Controller;

use Model\Manager\PostManager;

class BlogController extends Controller
{

    public function index()
    {
        $post = new PostManager();
        $allPost = $post->getAllPublic();
        //require_once __DIR__ . '/../views/test-view.php';
        //var_dump($allPost);
        //echo $allPost->getTitle().' '. $allPost->getContent();
        echo $this->twig->render('blog.html.twig',
            array(
                'posts' => $allPost
            )
        );

    }

    public function article($idpost)
    {
        //echo 'Voir un article '. $params;
        $post = new PostManager();
        $post = $post->getOne($idpost);
        echo $this->twig->render('article.html.twig',
            array(
                'post' => $post
            )
            );

    }
}