<?php
class TaskGateway{
    private PDO $db; // all public methods in gatwayclass will need to connect to the database
   public function __construct(Connection $database){ // we based database class so we can manipulate  the database
    $this->db = $database->getConnection();
   }

   public function getTasks(int $user_id):array{            

        $stmt = $this->db->prepare("SELECT * FROM `task` where user_id = ?");
        $stmt->execute(array($user_id));
        $vals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        foreach($vals as $val){
          $val['month'] = (bool) $val['month'];
          $data[] = $val;
        }
       return $data;
        
   }


   public function getData(Int $id,Int $user_id) :Array | null{
    
     $stmt =  $this->db->prepare("SELECT * FROM `task` WHERE id =? AND user_id = ?");
     $stmt->execute(array($id,$user_id));
     //$count = $stmt->fetchAll(PDO::FETCH_ASSOC);
     $count = $stmt->fetch(PDO::FETCH_ASSOC);
     if($count){
     $count['month'] = (bool) $count['month'];
     }else{
          return null;
     }
     return $count;
        
 }



 public function checkid(Int $id) :Bool{
     $stmt =  $this->db->prepare("SELECT * FROM `task` WHERE id =?");
     $stmt->execute(array($id));
     $count = $stmt->rowCount();
     if($count <= 0){
         return false;
     }else{
         return true;
     }
 }
 
 


 public function create($data,$userid){
     $stmt = $this->db->prepare("INSERT INTO `task` ( `name`, `month`,`age`,`user_id`) VALUES (:zone2,:ztwo,:zthree,:zfour)");
     $stmt->bindValue(":zone2",$data['name'],PDO::PARAM_STR);
     $stmt->bindValue(":zfour",$userid,PDO::PARAM_INT);
          $stmt->bindValue(":ztwo",$data['month'] ?? false,PDO::PARAM_BOOL);
     

     if(empty($data['age'])){
          $stmt->bindValue(":zthree",null,PDO::PARAM_NULL);
     }else{
          $stmt->bindValue(":zthree",$data['age'],PDO::PARAM_INT);
     }
     $stmt->execute();
 
 }
 public function delete(int $id,int $userid):int{
    $stmt = $this->db->prepare("DELETE FROM task WHERE id = ? AND user_id = ?");
    $stmt->execute(array($id,$userid));
    return $stmt->rowCount();
}

public function update(array $data, int $id,int $userid):bool{   


    $fields = [];
    if(array_key_exists('name',$data)){ // we used array_key_excist instead of empty because empyu will not work with null and false values
    $fields['name'] = [$data['name'],PDO::PARAM_STR];
    }
    if(array_key_exists('age',$data)){
        $fields['age'] = [$data['age'],$data['age'] === null ? PDO::PARAM_NULL:PDO::PARAM_INT];
    }
    if(array_key_exists('month',$data)){
        $fields['month'] = [$data['month'],PDO::PARAM_BOOL];
    }
    if(empty($fields)){
return 0;
    }else{
    
    $sets = array_map(function($value){
    return "$value = :$value";
    },array_keys($fields)); 

    $sql = "UPDATE task " . "SET " . implode(", ",$sets) . " WHERE id = :id AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$stmt->bindValue(":user_id",$userid,PDO::PARAM_INT);
foreach ($fields as $key => $value) {
    $stmt->bindValue(":$key",$value[0],$value[1]);
}
$stmt->execute();
return $stmt->rowCount();

    
    }
}
 
}
