<?php

require_once "dbConnect.php";
require_once "user.php";

class userUtil{
    
    public static function Signup($username, $password){
        $database = new DbConnect();
        $conn = $database->getConnection();
        
        $user = null;
        
        $sql = "INSERT INTO user (username,password) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        if ($stmt->execute()){
            $user = new User($username,$conn->lastInsertId());
        }
        
        $database->closeConnection();
        return $user;
    }
}

?>
