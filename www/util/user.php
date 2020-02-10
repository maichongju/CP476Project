<?php
require_once "dbConnect.php";
require_once "userError.php";

class User
{   
    private $username = null;
    private $userid = -1;
    
    public function __construct($username, $userid){
        $this->username = $username;
        $this->userid = $userid;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getUserId(){
        $this->userid;
    }

    
    
    
    
    
    
    
    
    
    
    

}
