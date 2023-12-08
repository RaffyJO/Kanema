<?php
require 'src/lib/Functions/Connections/DB.php';
require('src/lib/Functions/URLDetection.php');
require('src/lib/Functions/JWT_Utils.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Auth
{
    private $secretKey;
    private $is_Form;

    function __construct(array $server)
    {
        $this->secretKey = '8uRhAeH89naXfFXKGOEj';
        $urlDetector = new URLDetection();
        $this->is_Form = $urlDetector->is_formPost($server);
    }

    function exec()
    {
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
        $hash_password = hash_hmac('sha256', $postData['password'], $this->secretKey);

        echo $this->authorize($username, $hash_password);
        // if (!$this->is_Form) {
        // } else {
        //     if (!isset($_POST['username']) && !isset($_POST['password'])) {
        //         http_response_code(400);
        //         echo json_encode(array('error' => 'Username or Password are Missing'));
        //         exit;
        //     }

        //     $username = $_POST['username'];
        //     $hash_password = hash_hmac('sha256', $_POST['password'], $this->secretKey);

        //     $login_state = (array) json_decode($this->authorize($username, $hash_password));

        //     if (!array_key_exists('error', $login_state)) {
        //         $cookie =  setcookie('Bearer', $login_state['token'], $login_state['expire_at'] / 1000, '/');
        //         var_dump($cookie);
        //         // header('Location: /home');
        //         var_dump($_COOKIE);
        //         // exit;
        //     } else {
        //         header('Location: /login');
        //         echo "<script>alert('username or Password are Incorrect')</script>";
        //         exit;
        //     }
        // }
    }

    private function authorize(String $username, String $hash_password): string
    {
        try {
            $db = new DB();
            $connection = $db->getConnection();
            if ($connection == null) die(print_r("Connection is Null", true));

            $collection = $connection->selectCollection('kanema', 'users');
            $cursor = $collection->find(['username' => $username]);

            if ($cursor) {
                $arr = current($cursor->toArray());

                if (!isset($arr)) return json_encode(array('error' => 'Username or Pasword are Incorrect'));

                if (hash_equals($arr->password, $hash_password)) {
                    $jsonPayload = json_encode(array('username' => $arr->username, 'role' => $arr->role, 'id' => $arr->_id, 'exp' => time() + (1440 * 60) * 1000));

                    $jwt = new JWTUtils();
                    $accessToken = $jwt->sign($jsonPayload);

                    http_response_code(200);
                    return $accessToken;
                } else {
                    http_response_code(200);
                    return json_encode(array('error' => 'Username or Pasword are Incorrect'));
                }
            } else {
                http_response_code(200);
                return json_encode(array('error' => 'Username or Pasword are Incorrect'));
            }
        } catch (Exception $th) {
            http_response_code(400);
            return json_encode(array('error' => $th));
        }
    }
}
