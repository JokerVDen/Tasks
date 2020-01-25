<?php

 /** @var $router \Buki\Router */

$router->error(function() {
    echo view('errors.404');
});
$router->get('/', "TaskController@index");
$router->post('/task/store', ['before' => 'CsrfMiddleware'], "TaskController@store");
$router->get('/login', ['before' => 'AuthMiddleware'], "Auth\LoginController@index");
$router->post('/login', ['before' => 'AuthMiddleware'], "Auth\LoginController@login");
$router->post('/logout', ['before' => 'GuestMiddleware'], "Auth\LoginController@logout");
$router->get('/task/edit/{i}', ['before' => 'GuestMiddleware'], "Admin\TaskController@edit");
$router->patch('/task/update/{i}', ['before' => 'GuestMiddleware'], "Admin\TaskController@update");
