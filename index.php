<?php
$envConfig = parse_ini_file('.env');

if ($envConfig) {
    foreach ($envConfig as $key => $value) {
        putenv("$key=$value");
    }
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require 'src/Controllers/Controller.php';