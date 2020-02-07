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
    
    
    
    
    
    
    
    
    
    
    
    #----------------------------------------------------------------------
    #Parameter:     username(str):  username need to check
    #               password(str):  password need to be check
    #Return:        match(bool):    true if password match, otherwise false
    #----------------------------------------------------------------------

    public static function Login($username, $password, $logout)
    {
        # Get the connection to the database
        $conn = dbConnect::connect();
        $sql = 'SELECT userId, username, password,avatar from user where username = ?';
        # Get the statement ready
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $match = false;
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $password_hash = $row['password'];
            $match = password_verify($password, $password_hash);
            if ($match) {
                $loginKey = User::insertLoginKey($row['userId']);
                # must logout the other one
                if ($loginKey == '') {
                    $resultArray['error'] = Errorr::USER_LOGIN_KEY_ERROR;
                    $match = false;
                } else {
                    $resultArray['loginKey'] = $loginKey;
                    $resultArray['userId'] = $row['userId'];
                    $resultArray['username'] = $row['username'];
                    $resultArray['avatar'] = $row['avatar'];
                }
            }
        }
        $conn->close();
        $resultArray['isValid'] = $match;

        return $resultArray;
    }
    #----------------------------------------------------------------------
    #Parameter:     username(str):  The user's username
    #               password(str):  The user's password
    #Return:        userId(int):    New user ID
    #               key(str):       key for database to verify user
    #                               login status
    #Exception:     error(str):     error message
    #----------------------------------------------------------------------
    public static function signUp($username, $password)
    {
        # Getthe connection to the database
        $conn = dbConnect::connect();
        $p_hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = 'INSERT INTO user (username,password) VALUES (?,?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $p_hash);
        if ($stmt->execute()) {
            $result['status']='ok';
            $result['userId']=$conn->insert_id;
            $result['loginKey'] = User::insertLoginKey($conn->insert_id);
        } else {
            $result['status']='error';
            $result['errorCode']='username_exist';
            $result['errorMessage']=Errorr::USER_USERNAME_EXIST;
        }
        $conn->close();
        return $result;
    }

    #----------------------------------------------------------------------
    #Parameter:     userId(int):    The user's ID
    #               logout(str)
    #Return:        LoginKey(str):  hash key for current user
    #----------------------------------------------------------------------
    private static function insertLoginKey($userId)
    {
        $conn = dbConnect::connect();
        $hash_str = "$userId".time();
        $hash_v = hash('md5', $hash_str);
        $sql = "INSERT INTO user_login_key (userId,loginKey) VALUES (?,?) ON DUPLICATE KEY UPDATE loginKey=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $userId, $hash_v,$hash_v);
        # If statement execute success
        $stmt->execute();
        $conn->close();
        return $hash_v;
    }
}
