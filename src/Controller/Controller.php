<?php


namespace Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller
{

    protected $twig;
    protected $roleUser;
    protected $message;
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

    public function viewPage($twigpageElements)
    {
            echo $twigpageElements;
    }

    //abstract function index();

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
        return (isset($this->userSession) AND $this->userSession['role'] === 'ROLE_ADMIN');
    }

}