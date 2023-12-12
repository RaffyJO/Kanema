<?php

use MongoDB\BSON\ObjectId;

require_once('src/Models/Order.Model.php');
require_once('src/Controllers/Controller.php');
require_once('src/Models/Order.Model.php');

class OrderController implements Controller
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function routes()
    {
        $requestUri = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/order-clean') {
            $this->GETCLEAN();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/order-count') {
            $this->GETCOUNT();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/order-lastdays') {
            $this->GETLASTDAYS();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/order-best-seller-year') {
            $this->GETBESTSALLERYEAR();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET') {
            $this->GET();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'POST') {
            $this->POST();
            return;
        }
    }

    function GETBESTSALLERYEAR()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        // var_dump(gmdate("Y-m-d\TH:i:s\Z", 1699742424));

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $model = new OrderModel();
        echo $model->callCleanedDataSeller();
    }
    function GETCLEAN()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        // var_dump(gmdate("Y-m-d\TH:i:s\Z", 1699742424));

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $model = new OrderModel();
        echo $model->callCleanedData();
    }

    function GETCOUNT()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        // var_dump(gmdate("Y-m-d\TH:i:s\Z", 1699742424));

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $model = new OrderModel();
        echo $model->transactionCount();
    }

    function GETLASTDAYS()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        // var_dump(gmdate("Y-m-d\TH:i:s\Z", 1699742424));

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $model = new OrderModel();
        $countToday = ((array) json_decode(($model->countTransactionToday())))['count'];
        $countYesterday = ((array) json_decode(($model->countTransactionYesterday())))['count'];

        echo json_encode(array('today' => $countToday, 'yesterday' => $countYesterday));
    }

    function POST()
    {
        $productModel = new ProductModel();

        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $postData = json_decode(file_get_contents('php://input'), true);

        if (!isset($postData)) {
            http_response_code(400);
            echo json_encode(array('error' => 'Some Required Property are Missing'));
            return;
        }
        if (count((array)$postData['details']) < 1) {
            http_response_code(400);
            echo json_encode(array('error' => 'Some Required Property are Missing'));
            return;
        }

        $details = $postData['details'];
        $total = 0;

        foreach ($details as $key => $value) {
            $targetItem = $productModel->findOneItem($value['Product_id']);

            $subTotal = ((int)$value['qty']) * ((int)$targetItem['data']['price']);
            $details[$key] = array('Product_id' => new ObjectId($value['Product_id']), 'subtotal' => $subTotal, 'qty' => ((int)$value['qty']));

            $total += $subTotal;
        }

        $postData['users_id'] = new ObjectId($validToken['id']->{'$oid'});
        $postData['details'] = $details;
        $postData['total'] = $total;
        $postData['timestamp'] = time();

        $model = new OrderModel();
        $insertStatus = $model->createOrder($postData);

        if ($insertStatus) {
            http_response_code(200);
            echo json_encode(array('message' => 'Order Created'));
            return;
        } else {
            http_response_code(500);
            return;
        }
    }
    function GET()
    {
        # code...
    }

    function PUT()
    {
    }

    function DELETE()
    {
    }
}
