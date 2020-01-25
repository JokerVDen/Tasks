<?php

 /** @var $router \Buki\Router */

$router->error(function() {
    echo view('errors.404');
});
$router->get('/', "TaskController@index");
$router->post('/task/store', ['before' => 'CsrfMiddleware'], "TaskController@store");
$router->get('/login', ['before' => 'AuthMiddleware'], "LoginController@index");
$router->post('/login', ['before' => 'AuthMiddleware'], "LoginController@login");
$router->post('/logout', ['before' => 'GuestMiddleware'], "LoginController@logout");