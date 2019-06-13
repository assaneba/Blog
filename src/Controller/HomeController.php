<?php

namespace Controller;

class HomeController extends Controller
{

    public function index() {
        echo $this->twig->render('home.html.twig');
    }

    public function login() {
        echo $this->twig->render('login.html.twig');
    }

    public function register() {
        echo $this->twig->render('register.html.twig');
    }

}