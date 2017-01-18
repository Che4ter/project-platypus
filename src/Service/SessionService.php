<?php 
namespace Platypus\Service;
use DateTime;
use Firebase\JWT\JWT;

class SessionService {
    public function generateJWT($user, $secret, $token_timeout) {
        $token_timeout = (int)$token_timeout;
        if($token_timeout <= 0) {
            return null;
        }

        if(is_null($secret) || $secret == "") {
            return null;
        }

        $now = new DateTime();
        $future = new DateTime("now +" .$token_timeout . " seconds");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => base64_encode(random_bytes(16)),
            "sub" => $user->id,
            "role_id" => $user->role_id
        ];

        $token = JWT::encode($payload, $secret, "HS256");
        return $token;
    }
}
