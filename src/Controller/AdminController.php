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

}