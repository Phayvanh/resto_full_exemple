<?php

/*
 * Create a global constant used to get the filesystem path to the
 * application configuration directory.
 */
define('CFG_PATH', realpath(__DIR__.'/application/config'));

/*
 * Create a global constant used to get the filesystem path to the
 * application public web root directory.
 *
 * Can be used to handle file uploads for example.
 */
define('WWW_PATH', realpath(__DIR__.'/application/www'));


require_once 'library/Configuration.class.php';
require_once 'library/Database.class.php';
require_once 'library/Http.class.php';
require_once 'library/Form.class.php';
require_once 'library/FrontController.class.php';


// Create and execute the front controller.
$frontController = new FrontController();
$frontController->buildContext();
$frontController->run();
$frontController->renderView();