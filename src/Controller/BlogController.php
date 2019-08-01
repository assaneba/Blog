<?php

namespace Controller;

use Model\Manager\CommentManager;
use Model\Manager\PostManager;

class BlogController extends Controller
{
    private $message;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    public function index() {
        $post = new PostManager();
        $allPost = $post->getAllPublic();
        $page = $this->twig->render('blog.html.twig',
            array(
                'posts' => $allPost
            )
        );
        $this->viewPage($page);

    }

    public function article($idPost) {
        //echo 'Voir un article '. $params;
        $tabSession['userIduser'] = 2;
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
            $page = $this->twig->render('article.html.twig',
                array(
                    'post' => $post,
                    'comments' => $comments,
                    'session' => $tabSession
                ));
            $this->viewPage($page);
        } else {
            $this->message = 'Erreur 404 : post non trouvé';
        }

    }

    /**
     * @param $idPost
     * @var $idPost = id of the related post
     * @var $commentContent = content of the comment to add
     * @var $_SESSION['userIduser'] = content the id of the user which did the comment
     */
    public function addComment($postIdpost) {
        $tabSession['userIduser'] = NULL;
        $commentContent = filter_input(INPUT_POST, 'commentContent');
        if(isset($tabSession['userIduser'])) {
            $comment = new CommentManager();
            $insertCommentSucceed = $comment->addComment($commentContent, $postIdpost, $tabSession['userIduser']);
            if ($insertCommentSucceed) {
                $this->message = 'Votre commentaire a été bien enregistré !';
            } else {
                $this->message = 'Erreur commentaire non inséré ';
            }
        }
        else {
            $this->message = 'Veuillez vous authentifier pour commenter';
        }

    }

    public function editComment($commentId) {
        $jsonTab = array();
        $jsonTab['message'] = 'Edition de commentaire avec json';
        //echo 'Editer un commentaire <br> avec l\' id : '. $commentId;
        $newComment = filter_input(INPUT_POST, 'newComment');
        if(isset($newComment)) {
            $comment = new CommentManager();
            $editCommentSucceed = $comment->editComment($newComment, $commentId);
            if ($editCommentSucceed) {
                $jsonTab['message'] = 'Votre commentaire a été bien modifié !';
                $jsonTab['newComment'] = $newComment;
                $jsonTab['success'] = true;
            } else {
                $jsonTab['message'] = "Erreur commentaire non modifié";
            }
        }
        else {
            $jsonTab['message'] = 'Veuillez vous authentifier pour commenter';
        }
        $jsonEncode = json_encode($jsonTab);
        $this->viewPage($jsonEncode);

    }

    public function deleteComment($idComment) {
        $comment = new CommentManager();
        $response = $comment->deleteComment($idComment);
        if($response) {
            $this->message = 'Le commentaire a été bien supprimé ! <a href="../blog/article/2">Retour</a>';
        }

    }
}