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
        $twig = new Environment($loader);
        $this->twig = $twig;
    }

    public function viewPage($twigpageElements) {
            echo $twigpageElements;
    }

    abstract function index();

}