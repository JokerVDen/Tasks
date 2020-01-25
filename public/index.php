<?php

require __DIR__.'/../vendor/autoload.php';

if (!defined(DEV) && DEV) {
    ini_set('error_reporting', 0);
    ini_set('display_errors', 0);
} else {
    ini_set('error_reporting', 1);
    ini_set('display_errors', 1);
}

require __DIR__.'/../helpers/helpers.php';
require __DIR__.'/../bootstrap/app.php';