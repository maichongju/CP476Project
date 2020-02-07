<?php

require_once "user.php";
    if ($_SERVER['REQUEST_METHOD']=='GET'){
    
    }
    
    else if ($_SERVER['REQUEST_METHOD']=='POST'){
      $action = $_POST['action'];
      if ($action == 'login'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $logout = $_POST['logout'] ?? '';
        $result = User::Login($username,$password,$logout);
        echo json_encode($result);
      }
      elseif ($action == 'signup') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo json_encode(User::signUp($username,$password));
      }
    }

?>
