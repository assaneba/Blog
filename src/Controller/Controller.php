<?php

namespace Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller
{

    protected $twig;
    protected $roleUser;
    protected $session;
    protected $userSession;

    public function __construct() {
        $this->twig = new Environment(new FilesystemLoader(TEMPLATE_DIR));
        $this->session = filter_var_array($_SESSION);
        if (isset($this->session['user'])) {
            $this->userSession = $this->session['user'];
        }
        //$this->twig = $twig;
        //$this->roleUser = filter_input_array(INPUT_COOKIE);
    }


    public function showMessage(string $message)
    {
        $alert = "<script>alert('$message');</script>";
        $alert = filter_var($alert);
        $this->viewPage($alert);
    }

    public function viewPage($twigpageElements)
    {
            echo $twigpageElements;
    }

    abstract function index();

    public function createSession(int $idUser, string $username, string $role)
    {
        $_SESSION['user'] = [
            'id' => $idUser,
            'username' => $username,
            'role' => $role
        ];
    }

    public function checkAccessPanel()
    {
        if(isset($this->userSession) AND $this->userSession['role'] === 'ROLE_ADMIN')
            return true;
    }

}