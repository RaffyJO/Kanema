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
            require 'src/Views/dashboard.php';
            return;
        }
        if ($requestUri === '/api/user') {
            require 'src/Controllers/Users.Controller.php';
            $controller = new UsersController($this->server);
            $controller->routes();
            return;
        }
        if ($requestUri === '/api/user-all') {
            require 'src/Controllers/Users.Controller.php';
            $controller = new UsersController($this->server);
            $controller->routes();
            return;
        }

        if ($requestUri === '/api/auth') {
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
        if ($requestUri === '/cashier') {
            require 'src/Views/cashier.php';
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

        if ($requestUri === '/api/products') {
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController($this->server);
            $controller->route();
            return;
        }
        if (str_contains($requestUri, '/api/product?')) {
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController($this->server);
            $controller->route();
            return;
        }
        if ($requestUri === '/product') {
            require 'src/Views/product.php';
            return;
        }
    }
}
