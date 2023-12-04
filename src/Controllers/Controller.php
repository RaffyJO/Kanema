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
    require 'src/Models/Auth.php';
    return;
}

if ($requestUri === '/login_.php'){
    header('Location: src/Views/Login.php');
    exit;
    return;
}

if ($requestUri === '/login') {
    require 'src/Views/Login.php';
    return;
}

if ($requestUri === '/cashier') {
    require 'src/Views/templates/header.php';
    // require 'src/Views/product.php';
    require 'src/Views/templates/footer.php';
    return;
}