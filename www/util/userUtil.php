<?php

require_once "dbConnect.php";
require_once "user.php";

class userUtil{
    
    public static function Signup($username, $password){
        $user = null;
        $database = new DbConnect();
        $conn = $database->getConnection();

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

    public static function Login($username, $password){
        $database = new DbConnect();
        $user = null;
        $conn = $database->getConnection();

        $sql = "SELECT id, password, role from user where username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(1,$username);
        if ($stmt->execute()){
            $result = $stmt->fetchAll();
            // If there is only 1 record come back then it means it is correct
            if (count($result) === 1){
                $userid = $result[0]["id"];
                $h_pwd = $result[0]["password"];
                $userrole = $result[0]["role"];
                // If password match
                if (password_verify($password,$h_pwd)){
                    $user = new User($username,$userid,$userrole);
                }
            }
        }
        $database->closeConnection();
        return $user;
    }

}


