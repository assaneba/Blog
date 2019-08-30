<?php


namespace Controller;


use Model\Manager\UserManager;

class UserController extends Controller
{


    public function login()
    {
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if(isset($email) && isset($password)) {
            //echo $this->twig->render('login.html.twig');
            $checkUser = new UserManager();
            $user = $checkUser->checkUser($email, $password);

            if($user->getIdUser() === NULL ) {
                $this->message = 'Erreur utilisateur inexistant';
                //Faire une redirection
                $this->index();
            } else {
                /*
                  Here is the case where user exists
                  We check if the user is admin or simple user
                 */
                if($user->getUserRole() === 'ROLE_ADMIN') {
                    $this->createSession($user->getIdUser(), $user->getFirstName(), $user->getUserRole());
                    $home = new AdminController();
                    $home->index();
                }
                else {
                    $this->createSession($user->getIdUser(), $user->getFirstName(), $user->getUserRole());
                    $page = $this->twig->render('home.html.twig',
                        array(
                            'session' => $user
                        ));
                    $this->viewPage($page);
                }
            }
        }
        else {
            $page = $this->twig->render('login.html.twig');
            $this->viewPage($page);
        }
    }

    public function logout()
    {
        session_destroy();
        $page = $this->twig->render('login.html.twig');
        $this->viewPage($page);
    }

    /*
      First if condition test if the passwords set match
      In Second if condition
        We check if at first if the email or login is already exists in the database.
        If not we call addUser() function which add a new user
     */
    public function register()
    {
        $newUserData['password'] = filter_input(INPUT_POST, 'password');
        $newUserData['confirmPassword'] = filter_input(INPUT_POST, 'confirmPassword');
        $newUserData['email'] = filter_input(INPUT_POST, 'email');
        $newUserData['pseudo'] = filter_input(INPUT_POST, 'pseudo');
        $newUserData['firstName'] = filter_input(INPUT_POST, 'firstName');
        $newUserData['lastName'] = filter_input(INPUT_POST, 'lastName');
        //var_dump($newUserData);die;
        if(empty($newUserData))
        {
            if ($newUserData['password'] === $newUserData['confirmPassword']) {
                // if passwords match then do;
                $user = new UserManager();
                $emailAlreadyTaken = $user->checkEmail($newUserData['email']);
                $loginAlreadyTaken = $user->checkLogin($newUserData['pseudo']);
                if ($emailAlreadyTaken) {
                    $this->message = 'Erreur l\'email est déjà utilisé';

                } elseif ($loginAlreadyTaken) {
                    $this->message = 'Erreur ce pseudo est déjà pris';
                } else {
                    $newUserData['password'] = password_hash($newUserData['password'], PASSWORD_BCRYPT);
                    //var_dump($newUserData['password']);die;
                    $userAddSucceed = $user->addUser($newUserData['pseudo'], $newUserData['password'], $newUserData['firstName'], $newUserData['lastName'],
                        $newUserData['email']);
                    if ($userAddSucceed) {
                        $this->message = 'Utilisateur bien enrégistré !';
                        $this->index();
                    }

                }
            } else {
                $this->message = 'Erreur Les mots de passe ne correspondent pas';
            }
        }
        else
        {
            $page = $this->twig->render('register.html.twig');
            $this->viewPage($page);
        }

    }
}