<?php

use MongoDB\BSON\Iterator;
use MongoDB\Driver\Query;

    session_start();
    var_dump(getcwd());

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
        $hash_password = hash_hmac('sha256', $postData['password'],$secretKey);

        authorize($username,$hash_password);
        
        
    } else {
        if (!isset($_POST['username']) && !isset($_POST['password'])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Username or Password are Missing'));
            exit;
        }

        $username = $_POST['username'];
        $hash_password = hash_hmac('sha256', $_POST['password'],$secretKey);

        $login_state = authorize($username,$hash_password);

        $host = $_SERVER['HTTP_HOST'];

        if ($login_state) {
            header('Location: /Views/Home.php');
            exit;
        } else {
            header('Location: /login_.php');
            echo "<script>alert('username or Password are Incorrect')</script>";
            exit;
        }
    }

function authorize(String $username, String $hash_password) : bool {
    try {
        $connection = getConnection();
        if ($connection == null) die(print_r("Connection is Null",true));
        
        $queryOptions = ['username' => $username, 'password' => $hash_password];

        $query = new Query($queryOptions);
        $cursor = $connection->executeQuery('kanema.users',$query);

        var_dump($cursor);
        
        $iterator = new Iterator($cursor);
        $iterator->rewind();

        while ($var = $iterator->current()) {
            var_dump($var->current());
            $iterator->next();
        }

        if ($cursor){
            $arr = current($cursor->toArray());
            // var_dump(($result));
            // var_dump($arr);

            if (!isset($arr)) return false;

            if (hash_equals($arr->password, $hash_password)){
                $_SESSION['username'] = $arr->username;
                
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
        throw $th;
    } finally {
        sqlsrv_close($connection);
    }
}