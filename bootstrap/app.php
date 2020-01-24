<?php

use Buki\Router;


$params = require_once ROOT.'/config/params.php';
// Routing

// For right routing with izniburak/router
$_SERVER['PHP_SELF'] = "";
$router = new Router($params['routes']);
include_once ROUTES."/web.php";
$router->run();