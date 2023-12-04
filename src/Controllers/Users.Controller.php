<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $postData = json_decode(file_get_contents('php://input'), true);

    // Check if the 'name' parameter exists in the POST data
    if (isset($postData['name'])) {
        // Get the 'name' parameter value
        $name = $postData['name'];

        // Encode the name parameter
        $encodedName = base64_encode($name);

        // Redirect back to index.html with encoded name as a query parameter
        header('Location: index.html?encoded_name=' . urlencode($encodedName));
        exit;
    } else {
        // 'name' parameter is missing
        http_response_code(400); // Bad request
        echo json_encode(array('error' => 'Parameter "name" is missing.'));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require 'src/lib/Functions/Connections/DB.php';

    $connection = getConnection();

    $query = new MongoDB\Driver\Query(array());
    $cursor = $connection->executeQuery('kanema.users', $query);

    $data = array();

    foreach ($cursor as $key) {
        array_push(
            $data,
            array('username' => $key->username, 'password' => $key->password, 'role' => $key->role)
            
        );
    }

    http_response_code(200);
    echo json_encode(array('data' => $data));
}