<?php

 /** @var $router \Buki\Router */

$router->get('/', "MainController@index");
$router->post('/task/store', ['before' => 'CsrfMiddleware'], "MainController@store");
$router->get('/login', "LoginController@index");
$router->post('/login', "LoginController@login");