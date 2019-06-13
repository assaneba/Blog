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

    public function login()
    {

        if(isset($_POST['email']) && isset($_POST['password'])) {
            //echo $this->twig->render('login.html.twig');
            $user = new UserManager();
            $user = $user->getUser($_POST['email'], $_POST['password']);
            if($user->getIdUser() == NULL ) {
                echo 'Erreur Valeur inexistante';
            } else {
                echo 'Super valeur existe !';
                //echo $this->twig->render('admin/dashbord.html.twig');
            }
        } else {
            echo $this->twig->render('login.html.twig');
        }
    }

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
                $user->addUser($_POST['pseudo'], $_POST['password'], $_POST['firstName'], $_POST['lastName'],
                                        $_POST['email']);
                echo 'Utilisateur bien enrégistré ! <a href="../home/index"> Retour à l\'accueil  </a>' ;

            }
        } else {
            echo 'Erreur Les passwords ne correspondent pas';
        }

    }

}