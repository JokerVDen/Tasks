<?php


namespace App\MIddlewares;


use EasyCSRF\EasyCSRF;
use EasyCSRF\NativeSessionProvider;
use Exception;

class CsrfMiddleware
{
    public function handle()
    {
        $sessionProvider = new NativeSessionProvider();
        $easyCSRF = new EasyCSRF($sessionProvider);

        try {
            $easyCSRF->check('_csrf', $_POST['_csrf']);
        }
        catch(Exception $e) {
            return view('errors.csrf');
        }

        return true;
    }
}