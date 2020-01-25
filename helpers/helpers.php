<?php

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

if (!function_exists('asset')) {
    function asset($path)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
        if ($path == '/') return $url;
        return $url . $path;
    }
}

if(!function_exists('csrf_field')) {
    function csrf_field() {
        $sessionProvider = new EasyCSRF\NativeSessionProvider();
        $easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);

        $token = $easyCSRF->generate('_csrf');
        return '<input type="hidden" name="token" value="'.$token.'">';
    }
}