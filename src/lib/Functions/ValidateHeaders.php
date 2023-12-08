<?php
class ValidateHeaders
{
    public  static function validate($headers): bool
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(array('error' => 'Unautorized'));
            return false;
        }

        $jwt = new JWTUtils();
        $validToken = (array) json_decode($jwt->verivy(str_replace('Bearer ', '', $headers['Authorization'])));

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validToken);
            return false;
        }

        return true;
    }
}
