<?php


namespace App\Controllers;


use App\Services\LoginService;

class LoginController extends CoreController
{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Jenssegers\Blade\Blade
     */
    public function index()
    {
        return view('auth.login');
    }

    public function login()
    {
        $validateResult = $this->loginService->checkInputForLogin();
        if ($validateResult->isNotValid()) {
            return back(true, $validateResult->getMessages());
        }

        $result = $this->loginService->login($validateResult->getValues());
        if (!$result) {
            unset($_POST['password']);
            return back(true, ['Не верно введены данные, попробуйте снова!']);
        }

        return redirect('/');
    }

    public function logout()
    {
        $this->loginService->logout();
        return redirect('/');
    }
}