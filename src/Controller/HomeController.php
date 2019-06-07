<?php


namespace Controller;

class HomeController extends Controller
{

    public function index() {
        //echo 'Page Accueil du site' ;
        echo $view = $this->twig->render('blog.html.twig');
    }

}