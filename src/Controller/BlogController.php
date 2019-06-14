<?php


namespace Controller;

use Model\Manager\CommentManager;
use Model\Manager\PostManager;
session_start();

class BlogController extends Controller
{

    public function index() {
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

    public function article($idpost) {
        //echo 'Voir un article '. $params;
        $post = new PostManager();
        $post = $post->getOne($idpost);
        echo $this->twig->render('article.html.twig',
            array(
                'post' => $post
            )
            );

    }

    /**
     * @param $idPost
     * @var $idPost = id of the related post
     * @var $_POST['commentComment'] = content of the comment to add
     * @var $_SESSION['userIduser'] = content the id of the user which did the comment
     */
    public function addComment($postIdpost) {
        //echo 'recupération de commentaire';
        $_SESSION['userIduser'] = NULL;
        $_POST['commentContent'];
        if(isset($_SESSION['userIduser'])) {
            $comment = new CommentManager();
            $insertCommentSucceed = $comment->addComment($_POST['commentContent'], $postIdpost, $_SESSION['userIduser']);
            if ($insertCommentSucceed) {
                echo 'Votre commentaire a été bien enrégistré ! <a href="../blog/article/2"> Retour </a>';
            } else {
                echo 'Erreur commentaire non inséré ';
            }
        }
        else {
            echo 'Veuillez vous authentifier pour commenter';
        }

    }
}