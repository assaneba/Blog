<?php


namespace Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller
{

    protected $twig;
    protected $roleUser;
    protected $message;

    public function __construct() {
        $this->twig = new Environment(new FilesystemLoader(TEMPLATE_DIR));
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
    public function setMessage($message) {
        $this->message = $message;
    }

    public function viewPage($twigpageElements) {
            echo $twigpageElements;
    }

    abstract function index();

    public function setCookieRole($name, $value) {
        setcookie($name, $value, time() + 3600, null, null, false, true);
    }

    public function getCookieRole($name)
    {
        $this->roleUser = filter_input(INPUT_COOKIE, $name);

        return $this->roleUser;
    }

}