<?php

class Task{

    public function __construct(private TaskGateway $taskGateway,private Usergateway $usergatway,private $user_id){

    }
    public function proceessRequest(string $method,?string $id):void{
        if($id === null){
      
            if($method === "GET"){
                echo json_encode($this->taskGateway->getTasks($this->user_id));
            }else if($method === "POST"){
                
                $data = (array)json_decode(file_get_contents("php://input"),true);
                // json_decode return null if you entered to it invalid json, so that why we cast it as array so instead of returning null it returns empty array
                       $this->taskGateway->create($data,$this->user_id);
                       http_response_code(201); // this the reponse code that meaning creating has been successufl
                       echo json_encode(["message" => "itm has been created"]);
          

                       
                        
                       


            }else{
               $this->AloowMethods("Get,post");
              
            }
        }else{
            if(!$this->taskGateway->checkid($id)){
                $this->wrongId();
            }else{
            switch ($method) {
                case 'GET':
                    if($this->taskGateway->getData($id,$this->user_id)){
                    echo json_encode($this->taskGateway->getData($id,$this->user_id));
                    }else{
                        echo "no record excist";
                    }
                    break;
                    case 'PATCH':
                        $data = (array)json_decode(file_get_contents("php://input"),true);
                        $errors = $this->getValidationErrors($data);
                        if(empty($errors)){
                           if( $this->taskGateway->update($data,$id,$this->user_id)){
                            echo json_encode(["message" => "itm has been updated"]);
                           }else{
                            http_response_code(422);
                            echo json_encode(["message" => "something went wrong"]);
                           }
                        }else{
                        print_r( $errors);
                        }
                        break;
                        case 'DELETE':
                            $rows = $this->taskGateway->delete($id,$this->user_id);
                            echo json_encode(["message"=> "$rows has been deleted"]);

                            break;
                default:
                    # code...
                    break;
            }

        }
        }
    }

    public function AloowMethods(string $method):void{  
        http_response_code(405);
        header("Allow:$method");
    }

    private function wrongId() :void {
        http_response_code(501);
        echo json_encode(['message' => "you entered wrong id"]);
       }
    
       private function getValidationErrors(array $data, bool $is_new = true): array
       {
           $errors = [];
           
           if ($is_new && empty($data["name"])) {
               
               $errors[] = "name is required";
               
           }
           
           if ( ! empty($data["priority"])) {
               
               if (filter_var($data["priority"], FILTER_VALIDATE_INT) === false) {
                   
                   $errors[] = "priority must be an integer";
                   
               }
           }
           if(!empty($data['age'])){
            if(filter_var($data['age'], FILTER_VALIDATE_INT) === false){

                $errors[] = "age must be an integer";
            }
        }
           return $errors;
       }
   }
   

