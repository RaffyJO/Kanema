<?php
$envConfig = parse_ini_file('.env');

if ($envConfig) {
    foreach ($envConfig as $key => $value) {
        putenv("$key=$value");
    }
}

require 'src/Controllers/Controller.php';