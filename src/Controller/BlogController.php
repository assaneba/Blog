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

    public function article($idPost) {
        //echo 'Voir un article '. $params;
        $post = new PostManager();
        $post = $post->getOne($idPost);
        $comments = new CommentManager();
        $comments = $comments->getComments($idPost);
        //var_dump($comments);
        if($post) {
            if(!$comments) {
                //echo 'Aucun commentaire';
                $comments = NULL;
            }
            echo $this->twig->render('article.html.twig',
                array(
                    'post' => $post,
                    'comments' => $comments
                ));
        } else {
            echo 'Erreur 404 : post non trouvé';
        }

    }

    /**
     * @param $idPost
     * @var $idPost = id of the related post
     * @var $_POST['commentContent'] = content of the comment to add
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