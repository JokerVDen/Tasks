<?php

use App\Session;
use Buki\Router;
use App\Models\Database;


$session = Session::getInstance();
if ($session->old_already_get) {
    unset($session->old_already_get);
    unset($session->old_input);
}

$params = getParams();

//Initialize Illuminate Database Connection
new Database($params);

// Routing

// For right routing with izniburak/router
$_SERVER['PHP_SELF'] = "";
$router = new Router($params['routes']);
include_once ROUTES . "/web.php";
$router->run();