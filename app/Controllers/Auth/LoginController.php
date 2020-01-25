<?php


namespace App\Controllers\Auth;


use App\Controllers\CoreController;
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
        $pageTitle = "Вход";
        return view('auth.login', compact('pageTitle'));
    }

    /**
     * Login as admin
     */
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

    /**
     * Logout
     */
    public function logout()
    {
        $this->loginService->logout();
        return redirect('/');
    }
}