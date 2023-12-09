<?php

use MongoDB\BSON\ObjectId;

require_once('src/Models/Order.Model.php');

class OrderController
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function routes()
    {
        if ($this->server['REQUEST_METHOD'] === 'GET') {
            echo $this->GET();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'POST') {
            echo $this->POST();
            return;
        }
    }

    private function POST()
    {
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
            $subTotal = ((int)$value['qty']) * ((int)$value['price']);
            $details[$key] = array('Product_id' => new ObjectId($value['Product_id']), 'subtotal' => $subTotal, 'qty' => ((int)$value['qty']));

            $total += $subTotal;
        }

        $postData['users_id'] = new ObjectId($validToken['id']->{'$oid'});
        $postData['details'] = $details;
        $postData['total'] = $total;

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
    private function GET()
    {
        # code...
    }
}
