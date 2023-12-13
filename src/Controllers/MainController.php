<?php
require_once('src/Views/templates/source.php');
require_once('src/lib/Functions/ValidateHeaders.php');
require_once('src/lib/Functions/JtokenUtils.php');

class MainController
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    function validateAuth($queryParams): bool
    {
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        if (count($queryParams) < 1 && !isset($_COOKIE['Bearer'])) return false;
        if (!array_key_exists('token', $queryParams) && !isset($_COOKIE['Bearer'])) return false;

        if (array_key_exists('token', $queryParams)) {
            $validation = new ValidateHeaders();
            $validatedData = (array) json_decode($validation->validatePublic($queryParams['token']));

            if (array_key_exists('error', $validatedData)) {
                echo json_encode($validatedData);
                return false;
            }

            return true;
        }

        if (isset($_COOKIE['Bearer'])) {
            $validation = new ValidateHeaders();
            $validatedData = (array) json_decode($validation->validatePublic($_COOKIE['Bearer']));

            if (array_key_exists('error', $validatedData)) {
                echo json_encode($validatedData);
                return false;
            }

            return true;
        }
    }


    public function router()
    {
        $requestUri = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        $validToken = $this->validateAuth($queryParams);

        if ($requestUri === '/login') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            } else {
                require_once 'src/Views/dashboard.php';
                return;
            }
        }

        if ($requestUri === '/') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require_once 'src/Views/dashboard.php';
            return;
        }

        if ($requestUri === '/home') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require('src/Views/Home.php');
            return;
        }

        if ($requestUri === '/cashier') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require_once 'src/Views/cashier.php';
            return;
        }

        if ($requestUri === '/history') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require_once 'src/Views/history.php';
            return;
        }

        if ($requestUri === '/inbox') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require_once 'src/Views/inbox.php';
            return;
        }

        if ($requestUri === '/request') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require_once 'src/Views/request.php';
            return;
        }

        if ($requestUri === '/product') {
            if (!$validToken) {
                require_once 'src/Views/Login.php';
                return;
            }

            require_once 'src/Views/product.php';
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

        if ($requestUri === '/api/products') {
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController($this->server);
            $controller->routes();
            return;
        }

        if (str_contains($requestUri, '/api/product') && count($queryParams) > 0 && array_key_exists('search', $queryParams)) {
            require_once('src/Controllers/Products.Controller.php');
            $controller = new ProductsController($this->server);
            $controller->routes();
            return;
        }
      
        if (str_contains($requestUri, '/api/order')) {
            require_once('src/Controllers/Order.Controller.php');
            $controller = new OrderController($this->server);
            $controller->routes();
            return;
        }
      
        if (str_contains($requestUri, '/api/')) {
            http_response_code(404);
            echo json_encode(array('error' => 'API URL not found'));
            return;
        } else {
            http_response_code(404);
            require_once('src/Views/ControllerGone.php');
            return;
        }
        
    }
    private function validateLogin($token, $requestUri): bool
    {
        if ($token) {
            // if ($requestUri === '/login') {
            // require_once 'src/Views/dashboard.php';
            // }
            return true;
        } else {
            // header('Location: /login');
            // require_once 'src/Views/Login.php';
            return false;
        }
    }

    private function validateLogin($token, $requestUri): bool
    {
        if ($token) {
            // if ($requestUri === '/login') {
            // require_once 'src/Views/dashboard.php';
            // }
            return true;
        } else {
            // header('Location: /login');
            // require_once 'src/Views/Login.php';
            return false;
        }
    }
}
