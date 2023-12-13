<?php
require_once('src/Views/templates/source.php');
require_once('src/lib/Functions/ValidateHeaders.php');
require_once('src/lib/Functions/JtokenUtils.php');

class Controller
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
        $this->validateAuth();
    }

    function validateAuth()
    {
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        if (count($queryParams) < 1) return;
        if (!array_key_exists('token', $queryParams)) return;

        $validation = new ValidateHeaders();
        $validatedData = (array) json_decode($validation->validatePublic($queryParams['token']));

        if (array_key_exists('error', $validatedData)) {
            echo json_encode($validatedData);
            return;
        }

        if (!$validatedData['validState'] && array_key_exists('data', $validatedData)) return;

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        var_dump($_SESSION);

        // if (!isset($_SESSION['username']))
        //     if ($_SESSION['username'] == null)
        $_SESSION['username'] = ((array)$validatedData['data'])['username'];

        // if (!isset($_SESSION['role']))
        //     if ($_SESSION['role'] == null)
        $_SESSION['role'] = ((array)$validatedData['data'])['role'];

        // if (!isset($_SESSION['id']))
        //     if ($_SESSION['id'] == null)
        $_SESSION['id'] = ((array)$validatedData['data'])['id']->{'$oid'};
        var_dump($_SESSION);
    }


    public function router()
    {
        $requestUri = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        if ($requestUri === '/') {
            require_once 'src/Views/dashboard.php';
            return;
        }
        if ($requestUri === '/api/user') {
            require_once 'src/Controllers/Users.Controller.php';
            $controller = new UsersController($this->server);
            $controller->routes();
            return;
        }
        if ($requestUri === '/api/user-all') {
            require_once 'src/Controllers/Users.Controller.php';
            $controller = new UsersController($this->server);
            $controller->routes();
            return;
        }

        if ($requestUri === '/api/auth') {
            require_once 'src/Models/Auth.php';
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
            require_once 'src/Views/Login.php';
            return;
        }

        if ($requestUri === '/cashier') {
            require_once 'src/Views/cashier.php';
            return;
        }

        if ($requestUri === '/history') {
            require_once 'src/Views/history.php';
            return;
        }

        if ($requestUri === '/inbox') {
            require_once 'src/Views/inbox.php';
            return;
        }

        if ($requestUri === '/request') {
            require_once 'src/Views/request.php';
            return;
        }

        if ($requestUri === '/api/products') {
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController($this->server);
            $controller->route();
            return;
        }

        if ($requestUri === '/api/order') {
            require_once('src/Controllers/Order.Controller.php');
            $controller = new OrderController($this->server);
            $controller->routes();
            return;
        }

        if (str_contains($requestUri, '/api/product') && count($queryParams) > 0 && array_key_exists('search', $queryParams)) {
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController($this->server);
            $controller->route();
            return;
        }
        if ($requestUri === '/product') {
            require_once 'src/Views/product.php';
            return;
        } else {
            http_response_code(404);
            echo json_encode(array('error' => 'URL not found'));
            return;
        }
    }
}
