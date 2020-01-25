<?php


namespace App\Middlewares;


use App\Session;
use EasyCSRF\EasyCSRF;
use Exception;

class CsrfMiddleware
{
    public function handle()
    {
        $sessionProvider = Session::getInstance();
        $easyCSRF = new EasyCSRF($sessionProvider);
        try {
            if(!isset($_POST['_csrf'])) throw new Exception();
            $easyCSRF->check('_csrf', $_POST['_csrf']);
        }
        catch(Exception $e) {
            return view('errors.csrf');
        }

        return true;
    }
}