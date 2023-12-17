<?php

require_once('src/Models/RequestModel.php');
require_once('src/Controllers/Controller.php');
require_once('src/lib/Functions/MongoUtils.php');

class RequestController implements Controller
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

        if ($this->server['REQUEST_METHOD'] === 'POST') {
            $this->POST();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/requests') {
            $this->GETCLEAN();
            return;
        }
      
        if ($this->server['REQUEST_METHOD'] === 'PUT') {
            $this->PUT();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET') {
            $this->GET();
            return;
        }
    }

    function POST()
    {
    }

    function GET()
    {
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        $validation = new
            ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        if (!array_key_exists('search', $queryParams)) {
            echo json_encode(array('error' => 'Parameter "search" is required'));
            return;
        }
      
        if (!MongoUtils::isValidObjectId($queryParams['search'])) {
            echo json_encode(array('error' => 'Parameter "search" is not a valid objectId'));
            return;
        }

        $model = new RequestModel();
        $data = $model->get($queryParams['search']);

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

    function GETCLEAN()
    {
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        $validation = new
            ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $model = new RequestModel();
        $data = $model->getAll();

        // var_dump($data);
        header('Content-type: application/json');

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

    function PUT()
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

        $isValidObjectId = MongoUtils::isValidObjectId(is_string($postData['_id']) ? $postData['_id'] : ((array)$postData['_id'])['$oid']);

        if (!$isValidObjectId) {
            http_response_code(400);
            echo json_encode(array('error' => '_id is not a valid ObjectId'));
            return;
        }

        $id = null;
        if (is_string($postData['_id'])) $id = new ObjectId($postData['_id']);
        else $id  = new ObjectId(((array)$postData['_id'])['$oid']);

        unset($postData['_id']);

        $model = new RequestModel();
        $data = $model->update($id, $postData);

        header('Content-type: application/json');

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

    function DELETE()
    {
    }
}
