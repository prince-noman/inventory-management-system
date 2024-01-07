<?php
namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function createToken($userEmail, $userId) : string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel_Token',
            'iat' => time(),
            'exp' => time() + 3600,
            'userEmail' => $userEmail,
            'userId' => $userId
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function createTokenForSetPassword($email) : string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Laravel_Token',
            'iat' => time(),
            'exp' => time() + 60*5,
            'user_email' => $email,
            'user_id' => 0
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function verifyToken($token) : string | object
    {
        try{
            // If token doesn't exsits
            if(!$token){
                return 'Invalid Token';
            }else{
                $key = env('JWT_KEY');
                $payload = JWT::decode($token, new Key($key, 'HS256'));
                // return $payload->user_email;
                return $payload;
            }
        }catch(\Exception $e){
            return 'Invalid Token';
        }
    }
}