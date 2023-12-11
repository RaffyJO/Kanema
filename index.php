<?php
require_once __DIR__ . '/vendor/autoload.php';
$envConfig = parse_ini_file('.env');

if ($envConfig) {
    foreach ($envConfig as $key => $value) {
        putenv("$key=$value");
    }
}

require_once 'src/Controllers/MainController.php';
$mainRouter = new MainController($_SERVER);
$mainRouter->router();
