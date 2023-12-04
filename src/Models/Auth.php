<?php

session_start();
require 'src/lib/Functions/Connections/DB.php';
require('src/lib/Functions/URLDetection.php');
$secretKey = '8uRhAeH89naXfFXKGOEj';

$is_Form = is_formPost($_SERVER);

if (!$is_Form) {
    $postData = json_decode(file_get_contents('php://input'), true);

    if (!isset($postData)) {
        http_response_code(400);
        echo json_encode(array('error' => 'Username or Password are Missing'));
        return;
    }
    if (!isset($postData['username']) && !isset($postData['password'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Username or Password are Missing'));
        return;
    }

    $username = $postData['username'];
    $hash_password = hash_hmac('sha256', $postData['password'], $secretKey);

    authorize($username, $hash_password);
} else {
    if (!isset($_POST['username']) && !isset($_POST['password'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Username or Password are Missing'));
        exit;
    }

    $username = $_POST['username'];
    $hash_password = hash_hmac('sha256', $_POST['password'], $secretKey);

    $login_state = authorize($username, $hash_password);

    $host = $_SERVER['HTTP_HOST'];

    if ($login_state) {
        header('Location: /home');
        exit;
    } else {
        header('Location: /login');
        echo "<script>alert('username or Password are Incorrect')</script>";
        exit;
    }
}

function authorize(String $username, String $hash_password): bool
{
    try {
        $connection = getConnection();
        if ($connection == null) die(print_r("Connection is Null", true));

        $collection = $connection->selectCollection('kanema', 'users');
        $cursor = $collection->find(['username' => $username]);

        // var_dump($cursor->toArray());

        // foreach($cursor->toArray() as $key => $row) {
        //     var_dump($key); //your expected output
        //     echo $key;
        //     var_dump($row); //your expected output
        //     echo $row;
        // }

        // return false;

        if ($cursor) {
            $arr = current($cursor->toArray());

            if (!isset($arr)) return false;
            // var_dump(hash_equals($arr->password, $hash_password));

            if (hash_equals($arr->password, $hash_password)) {
                $_SESSION['username'] = $arr->username;
                $_SESSION['user_role'] = $arr->role;
                $_SESSION['user_id'] = $arr->_id;

                http_response_code(200);
                echo json_encode(array('username' => $arr->username, 'login_state' => true));
                return true;
            } else {
                http_response_code(200);
                echo json_encode(array('error' => 'Username or Pasword are Incorrect', 'login_state' => false));
                return false;
            }
        } else {
            http_response_code(200);
            echo json_encode(array('error' => 'Username or Pasword are Incorrect', 'login_state' => false));
            return false;
        }
    } catch (Exception $th) {
        http_response_code(400);
        echo json_encode(array('error' => $th, 'login_state' => false));
        var_dump($th);
        return false;
        // throw $th;
    }
}
