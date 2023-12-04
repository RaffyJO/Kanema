<?php
require_once('src/Views/templates/source.php');

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

if ($requestUri === '/home') {
    header('Location: src/Views/Home.php');
    exit;
    return;
}

if ($requestUri === '/login') {
    require 'src/Views/Login.php';
    return;
}

if ($requestUri === '/cashier') {
    require 'src/Views/product.php';
    return;
}

if ($requestUri === '/products') {
    require_once('src/Controllers/Products.Controller.php');
    $controller = new ProductsController();
    $controller->route();
    return;
}
