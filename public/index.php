<?php

require_once __DIR__. '/../config/bootstrap.php';
use Controller\Router;
$app = new Router();
$app->app();