<?php


namespace App\Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    function __construct($config)
    {
        $capsule = new Capsule;
        $configDB = $config['db'];
        $capsule->addConnection([
            'driver'    => $configDB['db_driver'],
            'host'      => $configDB['db_host'],
            'database'  => $configDB['db_name'],
            'username'  => $configDB['db_user'],
            'password'  => $configDB['db_password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->bootEloquent();
    }
}
