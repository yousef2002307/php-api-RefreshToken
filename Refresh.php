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
  $id = $payload['sub'];
  $database = new Connection($_ENV['DB_HOST'],$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_PASS']);

//check wheter token excist in db
$refreshtoken2 = new refreshgatway($database,$_ENV['SECRET_KEY']);
if($refreshtoken2->getbytoken($data['token']) === false){
  http_response_code(400);
  echo json_encode(["message" => "invalid refresh token"]);
  exit;
}








$usergatway = new Usergateway($database);
if($usergatway->getId2($id) === false){ // because if ftch the stmt does not return any recored it returns false
http_response_code(401);
echo json_encode(['message' => "id provided is not authorized to access api"]);
exit;
}
$userarr = $usergatway->getId2($id);
$payload = [
    "sub"=>$userarr['id'],
    "name"=> $userarr['name'],
    "exp" => time() + 40 // 20 means 20 seconds
    //time do Returns the current time measured in the number of seconds since the Unix Epoch (January 1 1970 00:00:00 GMT).
];

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
echo $refreshtoken2->delete($data['token']);
$refreshtoken2->create($refreshtoken,$exp);


  
//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImV4cCI6MTcyMDYzOTA1Mn0.eNr44fONpq8VlxZVU4xg3MaPjWVGrDKitdta4u1jHOQ