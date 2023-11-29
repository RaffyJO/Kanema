<?php
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/') {
    require 'src/Views/Landing.php';
    return;
}
if ($requestUri === '/user') {
    require 'src/Controllers/Users.Controller.php';
    return;
}
if ($requestUri === '/user-all') {
    require 'src/Controllers/Users.Controller.php';
    return;
}

if ($requestUri === '/auth') {

    // header('Location: Models/login.php');
    require 'src/Models/Auth.php';
    return;
}

if ($requestUri === '/login') {
    require 'src/Views/Login.php';
    return;
}