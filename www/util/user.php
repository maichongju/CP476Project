<?php
require_once "dbConnect.php";

class User
{   
    private $username = null;
    private $userid = -1;
    private $role = null;
    
    public function __construct($username, $userid, $role){
        $this->username = $username;
        $this->userid = $userid;
        $this->role = $role;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getUserId(){
        return $this->userid;
    }

    public function getRole(){
        return $this->role;
    }

    
    
    
    
    
    
    
    
    
    
    

}
