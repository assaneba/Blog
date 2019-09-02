<?php


namespace Controller;


use Model\Manager\UserManager;

class UserController extends Controller
{

    public function index()
    {
        if($this->checkAccessPanel()) {
            $users = new UserManager();
            $users = $users->getUsers();
            $page = $this->twig->render('admin/manage-users.html.twig', array(
                'users' => $users
            ));
            $this->viewPage($page);
        } else {
            $page = $this->twig->render('home.html.twig');
            $this->viewPage($page);
        }
    }

    public function login()
    {
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if(isset($email) && isset($password)) {
            $checkUser = new UserManager();
            $user = $checkUser->checkUser($email, $password);
            if($user === NULL ) {
                $this->message = 'Erreur utilisateur inexistant';
                //If user don't exist or password don't match
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
        //var_dump(isset($newUserData['password']));die;
        if(isset($newUserData['password']))
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
                    $userAddSucceed = $user->addUser($newUserData);
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

    /*
    On click on Modifier button on users' manager page
     */
    public function editUser($idUser)
    {
        //echo 'Sur la page edit user '. $idUser;
        $user = new UserManager();
        $user = $user->getUserbyId($idUser);
        $page = $this->twig->render('admin/modify-user.html.twig', array(
            'user' => $user
        ));
        $this->viewPage($page);
    }

    public function validateEditUser($idUser)
    {
        $userData['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $userData['firstName'] = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $userData['lastName'] = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $userData['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $userData['password1'] = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
        $userData['password2'] = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
        $userData['user_role'] = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        if(!empty($password1) AND !empty($password2)) {
            if($userData['password1'] === $userData['password2']) {
                $updateUser = new UserManager();
                $updateUser->updateUserWithPass($idUser, $userData);
                $this->index();
            }
        } else {
            $updateUser = new UserManager();
            //$updateUser->updateUser($idUser, $login, $firstName, $lastName, $email, $user_role);
            $updateUser->updateUser($idUser, $userData);
            $this->index();
        }
    }

    public function deleteUser($idUser)
    {
        $delUser = new UserManager();
        $delUser->deleteUser($idUser);
        $this->index();
    }

}