<?php

use Controller\Router;

require_once __DIR__. '/../config/bootstrap.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app = new Router();
$app->run();