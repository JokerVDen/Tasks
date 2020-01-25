<?php


namespace App\Controllers;


use App\Services\LoginService;

class LoginController
{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login()
    {
        $validateResult = $this->loginService->checkInputForLogin();
        if ($validateResult->isNotValid()) {
            back(true, $validateResult->getMessages());
        }
    }
}