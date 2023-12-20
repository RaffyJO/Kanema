<?php

use MongoDB\BSON\ObjectId;

require_once('src/Controllers/Controller.php');
require_once('src/Models/Product.Model.php');

class ProductsController implements Controller
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    function routes()
    {
        $requestUri = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);


        if (
            $this->server['REQUEST_METHOD'] === 'GET'
            && $this->server['REQUEST_URI'] === '/api/products'
        ) {
            echo $this->products();
        }

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/product' && array_key_exists('search', $queryParams)) {
            echo $this->GET();
        }

        if ($this->server['REQUEST_METHOD'] === 'PUT') {
            $this->PUT();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'DELETE') {
            $this->DELETE();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->POST();
        }
    }

    private function products()
    {
        $model = new ProductModel();
        $data = $model->getAll();

        header('content-type: application/json');
        if (array_key_exists('error', $data)) {
            http_response_code(400);
            echo json_encode($data);
            return;
        } else {
            http_response_code(200);
            echo json_encode($data);
            return;
        }
    }
    function GET()
    {
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        if (!array_key_exists('search', $queryParams)) {
            echo json_encode(array('error' => 'Parameter "search" is required'));
            return;
        }

        require_once('src/Models/Product.Model.php');
        $model = new ProductModel();
        $data = $model->getItem($queryParams['search']);

        if (array_key_exists('error', $data)) {
            http_response_code(400);
            echo json_encode($data);
            return;
        } else {
            http_response_code(200);
            echo json_encode($data);
            return;
        }
    }

    function POST()
    {
    }

    function PUT()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $postData = json_decode(file_get_contents('php://input'), true);

        $model = new ProductModel();
        $data = $model->updateStock($postData['id'], $postData['stock']);

        if (!$data) {
            http_response_code(400);
            echo json_encode(array('error' => 'Something went Wrond'));
            return;
        } else {
            http_response_code(200);
            echo json_encode(array('data' => 'Stock has been modified'));
            return;
        }
    }

    function DELETE()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $postData = json_decode(file_get_contents('php://input'), true);

        $model = new ProductModel();
        $data = $model->delete(new ObjectId($postData['id']));

        if (!$data) {
            http_response_code(400);
            echo json_encode(array('error' => 'Something went Wrond'));
            return;
        } else {
            http_response_code(200);
            echo json_encode(array('data' => 'Stock has been modified'));
            return;
        }
    }
}
