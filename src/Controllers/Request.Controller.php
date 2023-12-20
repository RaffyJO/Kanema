<?php

use MongoDB\BSON\ObjectId;

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

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/request-n') {
            $this->GETNEXT();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'PUT' && $requestUri === '/api/request-update') {
            $this->UPDATE();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'PUT') {
            $this->PUT();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'DELETE') {
            $this->DELETE();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET') {
            $this->GET();
            return;
        }
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

    function GETNEXT()
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

        if (!array_key_exists('page', $queryParams)) {
            echo json_encode(array('error' => 'Parameter "search" is required'));
            return;
        }

        $model = new RequestModel();
        $data = $model->getAllNext($queryParams['page']);

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
        $reqModel = new RequestModel();

        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $postData = json_decode(file_get_contents('php://input'), true);

        $requestContent = array(
            'user_id' => new ObjectId($validToken['id']->{'$oid'}),
            'time' => time(),
            'requests' => array(
                "status" => "pending",
                "type" => "delete",
                "itemID" => new ObjectId($postData['id']),
            ),
            'done' => false
        );

        $data = $reqModel->create($requestContent);

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

    function UPDATE()
    {
        $reqModel = new RequestModel();

        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $postData = json_decode(file_get_contents('php://input'), true);

        $base64_image = $postData['imgFile'];
        $requestContent = null;

        if ($base64_image != null) {
            // Remove the prefix from the base64 string
            $base64_image = preg_replace('/^data:image\/\w+;base64,/', '', $base64_image);

            // Decode the base64 string
            $decoded_image = base64_decode($base64_image);

            // Generate a unique filename or use the original filename if available
            $filename = 'uploaded_image_' . uniqid() . '.png'; // Example filename

            // Specify the path where the image will be stored
            $filepath = 'src/lib/Assets/uploads/' . $filename;

            // Write the decoded image data to the file
            file_put_contents($filepath, $decoded_image);

            $postData['fields']['imgUrl'] = $filepath;

            $requestContent = array(
                'user_id' => new ObjectId($validToken['id']->{'$oid'}),
                'time' => time(),
                'requests' => array(
                    "status" => "pending",
                    "type" => "update",
                    "itemID" => new ObjectId($postData['itemID']),
                    'fields' => $postData['fields'],
                ),
                'done' => false
            );
        } else {
            $requestContent = array(
                'user_id' => new ObjectId($validToken['id']->{'$oid'}),
                'time' => time(),
                'requests' => array(
                    "status" => "pending",
                    "type" => "update",
                    "itemID" => new ObjectId($postData['itemID']),
                    'fields' => $postData['fields'],
                ),
                'done' => false
            );
        }

        $data = $reqModel->create($requestContent);

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
        $reqModel = new RequestModel();

        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        $postData = json_decode(file_get_contents('php://input'), true);

        $base64_image = $postData['imgFile'];
        $requestContent = null;

        if ($base64_image != null) {

            // Remove the prefix from the base64 string
            $base64_image = preg_replace('/^data:image\/\w+;base64,/', '', $base64_image);

            // Decode the base64 string
            $decoded_image = base64_decode($base64_image);

            // Generate a unique filename or use the original filename if available
            $filename = 'uploaded_image_' . uniqid() . '.png'; // Example filename

            // Specify the path where the image will be stored
            $filepath = 'src/lib/Assets/uploads/' . $filename;

            // Write the decoded image data to the file
            file_put_contents($filepath, $decoded_image);

            $postData['field']['imgUrl'] = $filepath;

            $requestContent = array(
                'user_id' => new ObjectId($validToken['id']->{'$oid'}),
                'time' => time(),
                'requests' => array(
                    "status" => "pending",
                    "type" => "create",
                    "field" => $postData['field']
                ),
                'done' => false
            );
        } else {
            $requestContent = array(
                'user_id' => new ObjectId($validToken['id']->{'$oid'}),
                'time' => time(),
                'requests' => array(
                    "status" => "pending",
                    "type" => "create",
                    "field" => $postData['field']
                ),
                'done' => false
            );
        }

        $data = $reqModel->create($requestContent, $postData['imgFile']);

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
}
