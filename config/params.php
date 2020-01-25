<?php
$db = require CONFIG . '/db.php';
if (file_exists(CONFIG . '/db_web.php')) {
    $dbWeb = require CONFIG . '/db_web.php';
    $db = array_merge($db, $dbWeb);
}

return [
    'db'     => $db,
    'routes' => require CONFIG . '/route.php',
    'blade'  => require CONFIG . '/blade.php'
];