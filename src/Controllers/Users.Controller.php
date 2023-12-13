<?php

use MongoDB\BSON\ObjectId;

require_once('src/lib/Functions/ValidateHeaders.php');
require_once('src/lib/Functions/Connections/DB.php');
require_once('src/Controllers/Controller.php');

class UsersController implements Controller
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

        if ($this->server['REQUEST_METHOD'] === 'POST') {
            echo $this->POST();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/user-all') {
            echo $this->GETUSER();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET') {
            echo $this->GET();
            return;
        }
    }

    function POST()
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if (isset($postData['name'])) {
            $name = $postData['name'];
            $encodedName = base64_encode($name);

            echo json_encode(array('encoded_name' => urlencode($encodedName)));
            return;
        } else {
            http_response_code(400);
            echo json_encode(array('error' => 'Parameter "name" is missing.'));
            return;
        }
    }

    function GET()
    {
        $validation = new ValidateHeaders();
        $validToken = (array) json_decode($validation->validateData());

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validation);
            return;
        }

        http_response_code(200);
        echo json_encode(array('username' => $validToken['username'], 'role' => $validToken['role']));
    }

    function GETUSER()
    {
        $validation = new ValidateHeaders();
        $valid = $validation->validate();

        if (!$valid) return;

        $db = new DB();
        $connection = $db->getConnection();

        $collection = $connection->selectCollection('kanema', 'users');
        $cursor = $collection->find([]);

        $data = array();

        foreach ($cursor as $key) {
            array_push(
                $data,
                array('_id' => strval(new ObjectId($key->_id)), 'username' => $key->username, 'password' => $key->password, 'role' => $key->role)

            );
        }

        http_response_code(200);
        echo json_encode(array('data' => $data));
    }

    function PUT()
    {
    }
    function DELETE()
    {
    }
}
