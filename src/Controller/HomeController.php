<?php

namespace Controller;

class HomeController extends Controller
{

    public function index() {
        $page = $this->twig->render('home.html.twig');
        $this->viewPage($page);
    }

    public function login() {
        $page = $this->twig->render('login.html.twig');
        $this->viewPage($page);
    }

    public function register() {
        $page = $this->twig->render('register.html.twig');
        $this->viewPage($page);
    }

}