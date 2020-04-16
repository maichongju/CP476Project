<?php
require_once "util/errorMsg.php";
session_start();
// Check if it is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]){
    if (!isset($_SESSION["username"]) || !isset($_SESSION["userid"]) || !isset($_SESSION["userrole"])){
        // something went wrong. Logout and redirect back to login page
        setcookie("ERROR",errorMsg::SESSION_EXPIRED_ERROR);
        $_SESSION["loggedin"] = false;
        unset($_SESSION["username"]);
        unset($_SESSION["userid"]);
        unset($_SESSION["userrole"]);
        header("location: login.php");
    }
}


