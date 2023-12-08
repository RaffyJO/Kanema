<?php
require_once('src/Views/templates/source.php');

class Controller
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function router()
    {
        $requestUri = strtolower($this->server['REQUEST_URI']);

        if ($requestUri === '/') {
            require 'src/Views/Landing.php';
            return;
        }
        if ($requestUri === '/user') {
            require 'src/Controllers/Users.Controller.php';
            $controller = new UsersController($this->server);
            $controller->routes();
            return;
        }
        if ($requestUri === '/user-all') {
            require 'src/Controllers/Users.Controller.php';
            $controller = new UsersController($this->server);
            $controller->routes();
            return;
        }

        if ($requestUri === '/auth') {
            require 'src/Models/Auth.php';
            $controller = new Auth($this->server);
            $controller->exec();
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
            require 'src/Views/product.php';
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
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController();
            $controller->route();
            return;
        }
    }
}
