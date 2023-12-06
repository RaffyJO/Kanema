<?php
require_once('src/Views/templates/source.php');

$requestUri = strtolower($_SERVER['REQUEST_URI']);

if ($requestUri === '/') {
    require 'src/Views/dashboard.php';
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
    require('src/Views/Home.php');
    exit;
    return;
}

if ($requestUri === '/login') {
    require 'src/Views/Login.php';
    return;
}

if ($requestUri === '/cashier') {
    require 'src/Views/cashier.php';
    return;
}

if ($requestUri === '/history') {
    require 'src/Views/history.php';
    return;
}

if ($requestUri === '/inbox') {
    require 'src/Views/inbox.php';
    return;
}

if ($requestUri === '/products') {
    require 'src/Views/product.php';
    require_once('src/Controllers/Products.Controller.php');
    $controller = new ProductsController();
    $controller->route();
    return;
}
