<?php

use App\Session;
use Jenssegers\Blade\Blade;

function getParams()
{
    $params = require ROOT . '/config/params.php';
    return $params;
}


if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed
     * @return void
     */
    function dd()
    {
        array_map(function ($value) {
            if (class_exists(Symfony\Component\VarDumper\Dumper\CliDumper::class)) {
                $dumper = 'cli' === PHP_SAPI ?
                    new Symfony\Component\VarDumper\Dumper\CliDumper :
                    new Symfony\Component\VarDumper\Dumper\HtmlDumper;
                $dumper->dump((new Symfony\Component\VarDumper\Cloner\VarCloner)->cloneVar($value));
            } else {
                var_dump($value);
            }
        }, func_get_args());
        die(1);
    }
}

if (!function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string|null $view
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\View|Blade
     */
    function view($view = null, $data = [], $mergeData = [])
    {

        $params = getParams();
        $paramsBlade = $params['blade'];
        $blade = new Blade($paramsBlade['views'], $paramsBlade['cache']);

        if (func_num_args() === 0) {
            return $blade;
        }

        return $blade->make($view, $data, $mergeData);
    }
}

if (!function_exists('url')) {
    function url($uri, $args = [])
    {
        $uri = trim($uri, '/');
        $query = "";
        if ($args && is_array($args)) {
            $query = "?" . http_build_query($args);
        }

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return $url . $uri . $query;
    }
}

if (!function_exists('url_for_paginate')) {
    function url_for_paginate($uri, $page = 1, $order = [])
    {
        $args = $order;
        $args['page'] = $page;

        if (isset($args['orderBy']) && trim($args['orderBy']) == "") {
            unset($args['orderBy']);
        }

        if (isset($args['direction']) && trim($args['direction']) == "") {
            unset($args['direction']);
        }
        return url($uri, $args);
    }
}


if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        $sessionProvider = Session::getInstance();
        $easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);

        $token = $easyCSRF->generate('_csrf');
        return '<input type="hidden" name="_csrf" value="' . $token . '">';
    }
}

if (!function_exists('abort')) {
    function abort()
    {
        return view('errors.404');
    }
}

if (!function_exists('back')) {
    function back($withOldValues = false, $errors = [], $moveOnPage = "")
    {
        $session = Session::getInstance();
        if ($withOldValues) {
            $session->old_input = $_POST;
        }
        if ($errors) {
            $session->errors = $errors;
        }
        header('Location: ' . $_SERVER['HTTP_REFERER'] . $moveOnPage);
    }
}


if (!function_exists('redirect')) {
    function redirect($uri)
    {
        $url = url($uri);
        header('Location: ' . $url);
    }
}


if (!function_exists('old')) {
    function old($input, $default = "")
    {
        $session = Session::getInstance();
        if ($old = $session->old_input) {
            if (isset($old[$input])) {
                $value = $old[$input];
                unset($_SESSION['old_input'][$input]);
                $session->old_already_get = 1;
                return $value;
            }
        }
        return $default;
    }
}

if (!function_exists('errors')) {
    function errors()
    {
        $session = Session::getInstance();
        if ($errors = $session->errors) {
            unset($session->errors);
            return $errors;
        }
        return [];
    }
}

if (!function_exists('set_success')) {
    function set_success(string $message)
    {
        $session = Session::getInstance();
        $session->success = $message;
    }
}

if (!function_exists('get_success')) {
    function get_success()
    {
        $session = Session::getInstance();
        if ($success = $session->success) {
            unset($session->success);
            return $success;
        }
        return false;
    }
}

if (!function_exists('auth'))
{
    function auth() {
        $session = Session::getInstance();
        if ($session->admin) return true;
        return false;
    }
}