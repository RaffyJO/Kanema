<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JtokenUtils
{
    public function sign(string $jsonData): string
    {
        $SECRET = getenv('JWT_TOKEN');
        $payload = (array) json_decode($jsonData);

        $accessToken = JWT::encode($payload, $SECRET, 'RS256');

        return json_encode(array('token' => $accessToken, 'expire_at' => $payload['exp']));
    }

    public function verivy($accessToken): string
    {
        $SECRET = getenv('JWT_TOKEN_PUBLIC');

        try {
            $decodedToken = JWT::decode($accessToken, new Key($SECRET, 'RS256'));
            return json_encode((array) $decodedToken);
        } catch (Exception $e) {
            http_response_code(401);
            return json_encode(array('error' => $e->getMessage()));
        }
    }
}
