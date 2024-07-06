<?php

require("init.php");

    // Allow requests from any origin
  
  
    $headers =apache_request_headers();
    echo $headers['Authorization'];
    
$url = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) ;

//echo $url;
$urlArray = explode("/",$url);

$resource = $urlArray[2];

$id = $urlArray[3] ?? null;

if($resource !== "tasks"){
 
   http_response_code(404);
    exit;
}

    
    
    
    $database = new Connection($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $db = $database->getConnection();
$taskGateway = new TaskGateway($database);
$usergatway = new Usergateway($database);
$jwt = new JwtCode($_ENV['SECRET_KEY']);
$auth = new Auth($usergatway,$jwt);
if(!$auth->authen()){
exit;
}

$task = new Task($taskGateway,$usergatway,$auth->user);
$task->proceessRequest($_SERVER['REQUEST_METHOD'],$id);


//echo "\n". $jwt->encode(["id"=>222]);
