	<?php
	class refreshgatway{
    private PDO $conn;
    private string $key;
    
    public function __construct(Connection $database, string $key)
  {
       $this->conn = $database->getConnection();
	        $this->key = $key; // refer to the secret key in the env file
  }
   //to store token in database
    public function create(string $token, int $expiry): bool // we mad it Boolean because execute stement return true or false
    {
      $hash = hash_hmac("sha256", $token, $this->key); // because we want the token to be hashed in the db
       
        $sql = "INSERT INTO ret (ref, 	exp_at)
                VALUES (:token_hash, :expires_at)";
                
        $stmt = $this->conn->prepare($sql);
       
        $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);
       $stmt->bindValue(":expires_at", $expiry, PDO::PARAM_INT);
       
        return $stmt->execute();
    }


    public function delete(string $token):int{
        $hash = hash_hmac("sha256", $token, $this->key); // because we want the token to be hashed in the db
        
        $sql = "DELETE FROM ret WHERE ref = :token_hash";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->rowCount();
    }


    function getbytoken(string $token):array | false{
        $hash = hash_hmac("sha256", $token, $this->key); // because we want the token to be hashed in the db
        
        $sql = "SELECT * FROM `ret` WHERE ref = :token_hash";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteExpired(): int
    {
        $sql = "DELETE FROM ret
                WHERE exp_at < UNIX_TIMESTAMP()";
            
        $stmt = $this->conn->query($sql);
        
        return $stmt->rowCount();
    }


}

