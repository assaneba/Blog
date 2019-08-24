<?php

namespace Controller;

class Router
{
   public function run()
   {
       /*
             $_GET['url'] contains the url from rewrite of the .htaccess file
             @var $url[0] = controller name
             @var $url[1] = action or target
             @var $url[2] = parameter of an action
             @var  String $class contains recovered classname of the controller.
             @var String $target contains recovered name of the target or action
             @var array $params contains both GET and POST params if they are set
        */
       $getUrl = filter_input(INPUT_GET, 'url');
       $params = filter_input(INPUT_POST, 'params');
       $url = explode("/", $getUrl);
       $class = "Controller\\" . (!empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController');

       $target = isset($url[1]) ? $url[1] : "index";
       $getParams = isset($url[2]) ? $url[2] : null;
       $postParams = isset($params) ? $params : null;

       $params = ["get" => $getParams,
           "post" => $postParams];

       /*
         Verify wich class controller is called and its $target and $params if they exist
         Or it just call the index action of the controller
        */
       if (class_exists($class, true)) {
           $class = new $class();
           if (in_array($target, get_class_methods($class))) {
               call_user_func_array([$class, $target], $params);
           } else {
               call_user_func([$class, "index"]);
           }
       }
   }

}