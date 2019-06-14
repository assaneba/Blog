<?php

namespace Controller;

session_start();

use Model\Manager\UserManager;

class AdminController extends Controller
{
    public function index()
    {
        echo 'Page accueil dashbord';
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {

        if(isset($_POST['email']) && isset($_POST['password'])) {
            //echo $this->twig->render('login.html.twig');
            $checkUser = new UserManager();
            $user = $checkUser->getUser($_POST['email'], $_POST['password']);
            if($user->getIdUser() == NULL ) {
                echo 'Erreur User inexistante';
            } else {
                /**
                 * Here is the case where user exists
                 * We check if the user is admin or simple user
                 */
                if($user->getUserRole() == 'ROLE_ADMIN') {
                    echo 'Page d\'admin';
                    //echo $this->twig->render('admin/dashbord.html.twig');
                }
                else {
                    //On initialise les variables de session avec l'objet $user
                    $_SESSION = $user;
                    echo $this->twig->render('home.html.twig',
                        array(
                            'session' => $_SESSION
                        ));
                }
            }
        }
        else {
            echo $this->twig->render('login.html.twig');
        }
    }


    /**
     * First if condition test if the passwords set match
     * In Second if condition
        * We check if at first if the email or login is already exists in the database.
        * If not we call addUser() function which add a new user
     */
    public function register() {

        if($_POST['password'] == $_POST['confirmPassword']) {
            //echo 'Cool password correspond';
            $user = new UserManager();
            $emailAlreadyTaken = $user->checkEmail($_POST['email']);
            $loginAlreadyTaken = $user->checkLogin($_POST['pseudo']);
            if($emailAlreadyTaken) {
                echo 'Erreur l\'email est déjà utilisé <br>';

            } elseif ($loginAlreadyTaken) {
                echo 'Erreur ce pseudo est déjà pris';
            }
            else {
                $userAddSucceed = $user->addUser($_POST['pseudo'], $_POST['password'], $_POST['firstName'], $_POST['lastName'],
                                        $_POST['email']);
                if($userAddSucceed) {
                    echo 'Utilisateur bien enrégistré ! <a href="../home/index"> Retour à l\'accueil  </a>' ;
                }

            }
        } else {
            echo 'Erreur Les passwords ne correspondent pas';
        }

    }

}