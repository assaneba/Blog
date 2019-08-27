<?php

/**
 * APP CONFIG
 */
define('DEV_ENV', true);
define('TEMPLATE_DIR', __DIR__ . '/../src/views');
define('PUBLIC_DIR', __DIR__ . '/../public');

/**
 * DB CONFIG
 */
define('DB_NAME', 'blog');
define('DB_USER', 'root');
define('DB_PWD', 'root');
define('HOST_NAME', 'localhost');
define('DRIVER', 'mysql');

/**
 * MAIL CONFIG
 */
define('EMAIL_TO', 'testblogmail@yopmail.com'); // Add your email address in between the "" replacing testblogmail@yopmail.com - This is where the form will send a message to.