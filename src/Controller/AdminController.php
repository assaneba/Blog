<?php

namespace Controller;

use Model\Manager\CategoryManager;
use Model\Manager\CommentManager;
use Model\Manager\PostManager;
use Model\Manager\UserManager;

class AdminController extends Controller
{

    public function index()
    {
        if($this->checkAccessPanel()) {
            $getPosts = new PostManager();
            $posts = $getPosts->getAllPosts();
            $page  = $this->twig->render('admin/manage-posts.html.twig', array(
                'posts' => $posts
            ));
            $this->viewPage($page);
        } else {
            $page = $this->twig->render('login.html.twig');
            $this->viewPage($page);
        }
    }

    /*
      On click on Add post button in order to get the creation form of a new post
     */
    public function addPost()
    {
        $categories = new CategoryManager();
        $categories = $categories->getCategories();
        $page = $this->twig->render('admin/add-post.html.twig', array(
            'categories' => $categories
        ));
        $this->viewPage($page);
    }

    public function editPost(int $idPost)
    {
        $post = new PostManager();
        $post = $post->getOne($idPost);
        $category = new CategoryManager();
        $postCategory = $category->getCategory($idPost);
        $categories = $category->getCategories();
        $page = $this->twig->render('admin/modify-post.html.twig', array(
            'post' => $post,
            'postCategory' => $postCategory,
            'categories' => $categories
        ));
        $this->viewPage($page);

    }

    public function deletePost(int $idPost)
    {
        $delPost = new PostManager();
        $PostIsDeleted = $delPost->deletePost($idPost);
        if($PostIsDeleted) {
            $this->index();
        }
    }

    /**
     * After submitting a new post creation
     */
    public function submitNewPost()
    {
        $post['publicationDate'] = filter_input(INPUT_POST, 'plannedDate', FILTER_SANITIZE_STRING);
        $post['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $post['idCategory'] = filter_input(INPUT_POST, 'idCategory', FILTER_SANITIZE_NUMBER_INT);
        $post['lead'] = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_STRING);
        $post['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

        /**
         * The if condition get $publicationDate if it is set
         * And we delete the default T letter in the recover post value with str_replace function
         * Else we set $publicationDate to current timezone
         */
        if(!empty($post['publicationDate'])) {
            $post['publicationDate'] = str_replace('T', ' ',  $post['publicationDate']);
        } else {
            date_default_timezone_set('UTC');
            $post['publicationDate'] = date('Y/m/d h:i:s', time());
        }
        if(!empty($post['title']) && !empty($post['idCategory']) && !empty($post['lead']) && !empty($post['content'])) {
            //echo 'ok all Good';
            $postMan = new PostManager();
            //$newPostIsSaved = $postMan->addPost($title, $idCategory, $lead, $content, $publicationDate);

            $newPostIsSaved = $postMan->addPost($post);
            if ($newPostIsSaved) {
                //echo 'Post bien enregistré ! ';
                $this->index();
            }
        } else {
            $this->message = 'erreur tous les champs ne sont pas remplis';
        }
    }

    /**
     * After submitting to update post
     */
    public function submitUpdatePost()
    {
        $post['idPost'] = filter_input(INPUT_POST, 'idPost', FILTER_SANITIZE_NUMBER_INT);
        $post['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $post['idCategory'] = filter_input(INPUT_POST, 'idCategory', FILTER_SANITIZE_NUMBER_INT);
        $post['lead'] = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_STRING);
        $post['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
        if(!empty($post['title']) && !empty($post['idCategory']) && !empty($post['lead']) && !empty($post['content'])) {
            $postMan = new PostManager();
            $newPostIsSaved = $postMan->UpdatePost($post);
            if ($newPostIsSaved) {
                //echo 'Post bien mis à jour ! ';
                $this->index();
            }
        } else {
            $this->message = 'Erreur : certains champs ne sont pas remplis';
        }
    }

    /**
     * On click on Categories menu
     */
    public function categories()
    {
        if($this->checkAccessPanel()) {
            $category = new CategoryManager();
            $categories = $category->getCategories();
            $page = $this->twig->render('admin/manage-categories.html.twig', array(
                'categories' => $categories
            ));
            $this->viewPage($page);
        } else {
            $page = $this->twig->render('home.html.twig');
            $this->viewPage($page);
        }
    }

    /**
     * On click on add category button
     */
    public function addCategory ()
    {
        $nameCat = filter_input(INPUT_POST, 'nameCat', FILTER_SANITIZE_STRING);
        if(!empty($nameCat)) {
            //echo 'valeur remplie';
            $category = new CategoryManager();
            $category->addCategory($nameCat);
            $this->message = 'Catégorie bien enrégistrée';
            $this->categories();
        }

    }

    /*
      On click on Confirm Modify modal in categories manager page
     */
    public function editCategory(int $idCategory)
    {
        $nameCat = filter_input(INPUT_POST, 'nameCat', FILTER_SANITIZE_STRING);
        if(!empty($nameCat)) {
            $category = new CategoryManager();
            $category->editCategory($idCategory, $nameCat);
            $this->message = "Catégorie modifiée avec succès";
            $this->categories();
        }
    }

    /*
      On click on Confirm Delete category button
     */
    public function deleteCategory(int $idCategory)
    {
        $category = new CategoryManager();
        $deleteCat = $category->deleteCategory($idCategory);
        if($deleteCat) {
            $this->categories();
        }
    }

    public function comments()
    {
        if($this->checkAccessPanel()) {
            $comments = new CommentManager();
            $comments = $comments->getUnpublishedCom();
            $page = $this->twig->render('admin/manage-comments.html.twig', array(
                'comments' => $comments
            ));
            $this->viewPage($page);
        } else {
            $page = $this->twig->render('home.html.twig');
            $this->viewPage($page);
        }
    }

    /*
      On click on Approuver button to validate comments
     */
    public function validateComment(int $idComment)
    {
        $comment = new CommentManager();
        $validateCom = $comment->validateComment($idComment);
        if($validateCom)
            $this->message = "Commentaire Approuvé ! ";
            $this->comments();
    }

    /*
      On click on Supprimer button on comments page
     */
    public function deleteComment(int $idComment)
    {
        $comment = new CommentManager();
        $delComment = $comment->deleteComment($idComment);
        if($delComment)
            $this->comments();
    }


}