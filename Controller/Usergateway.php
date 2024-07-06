<?php
class Usergateway{
    private PDO $con;
    public function __construct(connection $database){
        $this->con = $database->getConnection();
    }
    public function checkapikey(string $key):int{
        $stmt = $this->con->prepare('SELECT * FROM `users` WHERE api_key = ?');
        $stmt->execute(array($key));
        $count = $stmt->rowCount();
        return $count;
    }

    public function getId(string $key):int{
        $stmt = $this->con->prepare('SELECT * FROM `users` WHERE api_key = ? LIMIT 1');
        $stmt->execute(array($key));
        $con1 = $stmt->rowCount();
        if($con1 <= 0){
            return 0;
        }
        $count = $stmt->fetch();
        return intval($count['id']);
    }


    public function getUserName(string $username):array|false{ // can return array or false
        $stmt = $this->con->prepare('SELECT * FROM `users` WHERE username = ?  LIMIT 1');
        $stmt->execute(array($username));
        $con1 = $stmt->rowCount();
       
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count;
    }
    public function getId2(int $id):array | false{
        $stmt = $this->con->prepare('SELECT * FROM `users` WHERE id = ? LIMIT 1');
        $stmt->execute(array($id));
       
       return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}



?>
