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
        $_SESSION['userIduser'] = 2;
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
                    'comments' => $comments,
                    'session' => $_SESSION
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

    public function editComment($commentId) {
        $jsonTab = array();
        $jsonTab['message'] = 'Edition de commentaire avec json';
        //echo 'Editer un commentaire <br> avec l\' id : '. $commentId;
        if(isset($_POST['newComment'])) {
            $comment = new CommentManager();
            $editCommentSucceed = $comment->editComment($_POST['newComment'], $commentId);
            if ($editCommentSucceed) {
                $jsonTab['message'] = 'Votre commentaire a été bien modifié !';
                $jsonTab['newComment'] = $_POST['newComment'];
                $jsonTab['success'] = true;
            } else {
                $jsonTab['message'] = "Erreur commentaire non modifié";
            }
        }
        else {
            $jsonTab['message'] = 'Veuillez vous authentifier pour commenter';
            header('Location: ../blog');
        }
        echo json_encode($jsonTab);

    }

    public function deleteComment($idComment) {
        /*$comment = new CommentManager();
        $response = $comment->deleteComment($idComment);*/
        $response = false;
        if($response) {
            echo 'Le commentaire a été bien supprimé ! <a href="../blog/article/2">Retour</a>';
        } else {
            echo 'Erreur, impossible de supprimer ce commentaire <a href="../blog/article/2">Retour</a>';
        }

    }
}