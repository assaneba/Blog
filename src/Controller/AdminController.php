<?php

namespace Controller;

use Model\Manager\CategoryManager;
use Model\Manager\PostManager;
use Model\Manager\UserManager;

class AdminController extends Controller
{
    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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



    public function index()
    {
        $accessTest = true;
        /**
        Test if the user have the rights to access admin dashbord, else we redirect to home
         */
        if($accessTest) {
            $posts = new PostManager();
            $posts = $posts->getAllPosts();
            $page = $this->twig->render('admin/manage-posts.html.twig', array(
                'posts' => $posts
            ));
            $this->viewPage($page);
        } else {
            $page = $this->twig->render('home.html.twig');
            $this->viewPage($page);
        }

    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        if(isset($email) && isset($password)) {
            //echo $this->twig->render('login.html.twig');
            $checkUser = new UserManager();
            $user = $checkUser->getUser($email, $password);
            if($user->getIdUser() == NULL ) {
                $this->message = 'Erreur User inexistante';
            } else {
                /**
                 * Here is the case where user exists
                 * We check if the user is admin or simple user
                 */
                if($user->getUserRole() == 'ROLE_ADMIN') {
                    $this->message = 'Page d\'admin';
                    //echo $this->twig->render('admin/dashbord.html.twig');
                }
                else {
                    //On initialise les variables de session avec l'objet $user
                    $page = $this->twig->render('home.html.twig',
                        array(
                            'session' => $user
                        ));
                    $this->viewPage($page);
                }
            }
        }
        else {
            $page = $this->twig->render('login.html.twig');
            $this->viewPage($page);
        }
    }


    /**
     * First if condition test if the passwords set match
     * In Second if condition
        * We check if at first if the email or login is already exists in the database.
        * If not we call addUser() function which add a new user
     */
    public function register() {

        $password = filter_input(INPUT_POST, 'password');
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
        $email = filter_input(INPUT_POST, 'email');
        $pseudo = filter_input(INPUT_POST, 'pseudo');
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        if($password == $confirmPassword) {
            //echo 'Cool password correspond';
            $user = new UserManager();
            $emailAlreadyTaken = $user->checkEmail($email);
            $loginAlreadyTaken = $user->checkLogin($pseudo);
            if($emailAlreadyTaken) {
                $this->message = 'Erreur l\'email est déjà utilisé <br>';

            } elseif ($loginAlreadyTaken) {
                $this->message = 'Erreur ce pseudo est déjà pris';
            }
            else {
                $userAddSucceed = $user->addUser($pseudo, $password, $firstName, $lastName,
                                        $email);
                if($userAddSucceed) {
                    $this->message = 'Utilisateur bien enrégistré ! <a href="../home/index"> Retour à l\'accueil  </a>' ;
                }

            }
        } else {
            $this->message = 'Erreur Les passwords ne correspondent pas';
        }

    }

    /**
     * On click on Add post button in order to get the creation form of a new post
     */
    public function addPost() {
        $categories = new CategoryManager();
        $categories = $categories->getCategories();
        $page = $this->twig->render('admin/add-post.html.twig', array(
            'categories' => $categories
        ));
        $this->viewPage($page);
    }

    public function editPost($idPost) {
        //echo 'edit post '. $idPost;
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

    public function deletePost($idPost) {
        $delPost = new PostManager();
        $PostIsDeleted = $delPost->deletePost($idPost);
        if($PostIsDeleted) {
            $this->index();
        }
    }

    /**
     * After submitting a new post creation
     */
    public function submitNewPost() {
        $publicationDate = filter_input(INPUT_POST, 'plannedDate', FILTER_SANITIZE_STRING);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $idCategory = filter_input(INPUT_POST, 'idCategory', FILTER_SANITIZE_NUMBER_INT);
        $lead = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_STRING);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

        /**
         * The if condition get $publicationDate if it is set
         * And we delete the default T letter in the recover post value with str_replace function
         * Else we set $publicationDate to current timezone
         */
        if(!empty($publicationDate)) {
            $publicationDate = str_replace('T', ' ',  $publicationDate);
        } else {
            date_default_timezone_set('UTC');
            $publicationDate = date('Y/m/d h:i:s', time());
        }
        if(!empty($title) && !empty($idCategory) && !empty($lead) && !empty($content)) {
            //echo 'ok all Good';
            $postMan = new PostManager();
            $newPostIsSaved = $postMan->addPost($title, $idCategory, $lead, $content, $publicationDate);
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
    public function submitUpdatePost() {
        $idPost = filter_input(INPUT_POST, 'idPost', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $idCategory = filter_input(INPUT_POST, 'idCategory', FILTER_SANITIZE_NUMBER_INT);
        $lead = filter_input(INPUT_POST, 'lead', FILTER_SANITIZE_STRING);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
        if(!empty($title) && !empty($idCategory) && !empty($lead) && !empty($content)) {
            $postMan = new PostManager();
            $newPostIsSaved = $postMan->UpdatePost($idPost, $title, $idCategory, $lead, $content);
            if ($newPostIsSaved) {
                //echo 'Post bien mis à jour ! ';
                $this->index();
            }
        } else {
            $this->message = 'Erreur : certains champs ne sont pas remplis';
        }
    }

    /**
     * On click on add category button
     */
    public function categories() {
        $accessTest = true;
        /**
        Test if the user have the rights to access admin dashbord, else we redirect to home
         */
        if($accessTest) {
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
    public function addCategory () {
        $nameCat = filter_input(INPUT_POST, 'nameCat', FILTER_SANITIZE_STRING);
        if(!empty($nameCat)) {
            //echo 'valeur remplie';
            $category = new CategoryManager();
            $category->addCategory($nameCat);
            $this->message = 'Catégorie bien enrégistrée';
            $this->categories();
        }

    }

    public function editCategory($idCategory) {
        $nameCat = filter_input(INPUT_POST, 'nameCat', FILTER_SANITIZE_STRING);
        if(!empty($nameCat)) {
            $category = new CategoryManager();
            $category->editCategory($idCategory, $nameCat);
            $this->message = "Catégorie modifiée avec succès";
            $this->categories();
        }

    }

    public function deleteCategory($idCategory) {
        $category = new CategoryManager();
        $deleteCat = $category->deleteCategory($idCategory);
        if($deleteCat) {
            $this->categories();
        }
    }

}