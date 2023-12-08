<?php

use MongoDB\BSON\ObjectId;

require('src/lib/Functions/JWT_Utils.php');
require('src/lib/Functions/ValidateHeaders.php');

class UsersController
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }
    function routes()
    {
        if ($this->server['REQUEST_METHOD'] === 'POST') {
            echo $this->POST();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'GET') {
            echo $this->GET();
            return;
        }
    }

    function POST(): string
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if (isset($postData['name'])) {
            $name = $postData['name'];
            $encodedName = base64_encode($name);

            return json_encode(array('encoded_name' => urlencode($encodedName)));
        } else {
            http_response_code(400);
            return json_encode(array('error' => 'Parameter "name" is missing.'));
        }
    }

    function GET()
    {
        $validation = new ValidateHeaders();
        $valid = $validation->validate(getallheaders());

        if (!$valid) return;

        require 'src/lib/Functions/Connections/DB.php';
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
}
