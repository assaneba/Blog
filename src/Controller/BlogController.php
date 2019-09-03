<?php

namespace Controller;

use Model\Manager\CommentManager;
use Model\Manager\PostManager;

class BlogController extends Controller
{

    public function index()
    {
        $post = new PostManager();
        $allPost = $post->getAllPublic();
        $page = $this->twig->render('blog.html.twig',
            array(
                'posts' => $allPost
            )
        );
        $this->viewPage($page);

    }

    public function article(int $idPost)
    {
        $post = new PostManager();
        $post = $post->getOne($idPost);
        $comments = new CommentManager();
        $comments = $comments->getComments($idPost);
        if($post) {
            if(!$comments) {
                $comments = NULL;
            }
            $page = $this->twig->render('article.html.twig',
                array(
                    'post' => $post,
                    'comments' => $comments
                ));
            $this->viewPage($page);
        } else {
            $page = $this->twig->render('error404.html.twig');
            $this->viewPage($page);
            $this->showMessage('Erreur 404 : post non trouvé');
        }

    }

    /**
     * @param $idPost
     * @var $idPost = id of the related post
     * @var $commentContent = content of the comment to add
     */
    public function addComment(int $postIdpost)
    {
        $commentContent = filter_input(INPUT_POST, 'commentContent');
        if(isset($this->userSession['id'])) {
            $comment = new CommentManager();
            $insertCommentSucceed = $comment->addComment($commentContent, $postIdpost, $this->userSession['id']);
            if ($insertCommentSucceed) {
                $this->article($postIdpost);
                $this->showMessage('Votre commentaire a été bien enregistré ! Il est en attente de validation. Merci de votre patience...' );
            } else {
                $this->article($postIdpost);
                $this->showMessage('Erreur commentaire non inséré ');
            }
        }
        else {
            $this->article($postIdpost);
            $this->showMessage('Veuillez vous authentifier pour commenter');
        }

    }

    public function editComment(int $commentId)
    {
        $jsonTab = array();
        //$jsonTab['message'] = 'Edition de commentaire avec json';
        $newComment = filter_input(INPUT_POST, 'newComment');
        if(isset($newComment))
        {
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
            $this->index();
        }
        $jsonEncode = json_encode($jsonTab);
        $this->viewPage($jsonEncode);

    }

    public function deleteComment(int $idComment)
    {
        $comment = new CommentManager();
        $commentIsDeleted = $comment->deleteComment($idComment);
        if($commentIsDeleted) {
            $this->index();
            $this->showMessage('Le commentaire a été bien supprimé ! ');
        }

    }
}