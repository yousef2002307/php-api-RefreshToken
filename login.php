<?php

include "init.php";
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
   http_response_code(405);
   header("Allow:post");
   exit;

}
$data = (array) json_decode(file_get_contents("php://input"),true);
if(!array_key_exists("username",$data) || !array_key_exists("pass",$data)){
http_response_code(400);
echo json_encode(['message' => "wrong username and password"]);
exit;
}
print_r($data);
$database = new Connection($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$user = new Usergateway($database);
$userarr =$user->getUserName($data['username']);
if($userarr === false){
    http_response_code(401);
    echo json_encode(['message' => "wrong username"]);
exit;
}
if(!password_verify($data['pass'],$userarr['pass']) ){
    http_response_code(401);
    echo json_encode(['message' => "wrong pass"]);
exit;
}
$payload = [
    "sub"=>$userarr['id'],
    "name"=> $userarr['name'],
    "exp" => time() + 60 // 20 means 20 seconds
    //time do Returns the current time measured in the number of seconds since the Unix Epoch (January 1 1970 00:00:00 GMT).
];


$jwt = new JwtCode($_ENV['SECRET_KEY']);
$accesstoken= $jwt->encode($payload);
$exp = time() + 432000;
$refreshtoken= $jwt->encode([
    "sub" => $userarr['id'],
    "exp" => $exp
]);

echo $accesstoken = json_encode([
    "accesstoken" => $accesstoken,
    "refresh token" => $refreshtoken
]);
$refreshtoken2 = new refreshgatway($database,$_ENV['SECRET_KEY']);
$refreshtoken2->create($refreshtoken,$exp); // database recored will be created for refresh token

//print_r($jwt->decode("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsIm5hbWUiOiJqbyJ9.GVpi7FI7Y_TCX6qgIOdphx1uag9MeFyEClZAfYIUUeQ"));
//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsIm5hbWUiOiJ5b3VzZWYgYWhtZWQifQ.uWfpeEIV3KsuK2dEepDEOBPYxUQcyBFd7lQUUw6JpXQ

//eyJpZCI6MSwibmFtZSI6ImRvYzUifQ==

//refresh : eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImV4cCI6MTcyMDYzOTA1Mn0.eNr44fONpq8VlxZVU4xg3MaPjWVGrDKitdta4u1jHOQ
//access : eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsIm5hbWUiOiJ5b3VzZWYgYWhtZWQiLCJleHAiOjE3MjAyMDcwNzJ9.tQjAX1C0e4RhZWMsZKALXnxWIY-EAZ2EKejcvRoRIjA


