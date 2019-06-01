<?php

//Gère les routes vers les différents controllers de l'application
//

$class = "Controller\\" . (isset($_GET['admin'])  ? 'AdminController' : 'HomeController');
$target = isset($_GET['t']) ? $_GET['t'] : "index";
$getParams = isset($_GET['params']) ? $_GET['params'] : null;
$postParams = isset($_POST['params']) ? $_POST['params'] : null;
$params = [
    "get"  => $getParams,
    "post" => $postParams
];

if (class_exists($class, true))
{
    $class = new $class();
    if (in_array($target, get_class_methods($class))) {
        call_user_func_array([$class, $target], $params);
    } else {
        call_user_func([$class, "index"]);
    }
}
else {
    echo "404 - Error";
}