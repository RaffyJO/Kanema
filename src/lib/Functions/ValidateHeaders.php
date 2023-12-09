<?php

class ValidateHeaders
{
    private $jwtUtils;

    public function __construct()
    {
        $this->jwtUtils = new JtokenUtils();
    }

    public function validate(): bool
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(array('error' => 'Unautorized'));
            return false;
        }

        $verifydToken = $this->jwtUtils->verivy(str_replace('Bearer ', '', $headers['Authorization']));
        $validToken = (array) json_decode($verifydToken);

        if (array_key_exists('error', $validToken)) {
            echo json_encode($validToken);
            return false;
        }

        return true;
    }

    public function validateData(): string
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            return json_encode(array('error' => 'Unautorized'));;
        }

        $verifydToken = $this->jwtUtils->verivy(str_replace('Bearer ', '', $headers['Authorization']));
        $validToken = (array) json_decode($verifydToken);

        if (array_key_exists('error', $validToken)) {
            return json_encode($validToken);
        }

        return $verifydToken;
    }

    public function validatePublic($QueryToken): string
    {
        if (isset($QueryToken['token'])) {
            $verifydToken = $this->jwtUtils->verivy(str_replace('Bearer ', '', $QueryToken['token']));
            $validToken = (array) json_decode($verifydToken);

            if (array_key_exists('error', $validToken)) {
                return json_encode(array('validState' => false, 'error' => $validToken['error']));
            }

            return json_encode(array('validState' => true, 'data' => $validToken));
        }

        return json_encode(array('validState' => false, 'data' => 'Authorization is Missing'));
    }
}
