<?php

namespace App\Middleware\Support;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class FirebaseAuth
{
    public function __construct()
    {
    }

    public static function generateToken($payload = '')
    {
        $issued_at = new \DateTimeImmutable();
        $expire = $issued_at->modify('+120 minutes')->getTimestamp();
        $secretKey = $_ENV['JWT_SECRET_KEY'];

        $payload = [
            'jti' => $payload,
            'iat' => $issued_at->getTimestamp(),
            'exp' => $expire
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public function decodeToken($token = '')
    {
        return JWT::decode($token, new Key(env('JWT_SECRET_KEY'), 'HS256'));
    }

}