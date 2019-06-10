<?php


namespace Controller;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

abstract class Controller
{

    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(TEMPLATE_DIR);
        $this->twig = $twig = new Environment($loader);
    }

    abstract function index();

}