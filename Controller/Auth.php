<?php
class Auth{
    public $user = 0;
    public function __construct(private Usergateway $usergatway,private JwtCode $jwt){

    }
   public function authen(){
       	        $headers =apache_request_headers();
               if(!isset($headers['Authorization'])){
        	            http_response_code(400);
        	            echo json_encode(["message" => "incomplete authorization header"]);
        	            return false;
                }
        	        
            if ( ! preg_match("/^Bearer\s+(.*)$/", $headers['Authorization'], $matches)) {
    	            http_response_code(400);
        	            echo json_encode(["message" => "incomplete authorization header"]);
                    return false;
                }
               
        	       //we add try catch block because remember in encode methods we had certain conditions that throw exceptions so we want caught them and show the error as json
                   try {
                    $data = $this->jwt->decode($matches[1]);
                }catch(SignExp){
                    http_response_code(401);
                    echo json_encode(["message",'signature do not match']);
                    return false;
                } catch(TimeExp){
                    http_response_code(401);
                    echo json_encode(["message",'token has expired']);
                    return false;
                } 
        
                catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(["message",$e->getMessage()]);
                    return false;
                }
        
               $this->user =  $data['sub'];
                return true;
        	    }
        
}
