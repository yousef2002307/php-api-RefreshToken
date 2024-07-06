<?php

include "init.php";
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
   http_response_code(405);
   header("Allow:post");
   exit;

}

$data = (array) json_decode(file_get_contents("php://input"),true);
if(!array_key_exists("token",$data)){
http_response_code(400);
echo json_encode(['message' => "msiiing credentials"]);
exit;
}
try {
  $jwt = new JwtCode($_ENV['SECRET_KEY']);
  $payload = $jwt->decode($data['token']);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["message" => "token are not correct"]);
    exit;
}

$database = new connection($_ENV['DB_HOST'],$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_PASS']);
$refreshtoken2 = new refreshgatway($database,$_ENV['SECRET_KEY']);



 $refreshtoken2->delete($data['token']);
