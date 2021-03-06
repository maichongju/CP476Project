<?php
if (isset($_GET["fileid"])){
    require_once "util/fileUtil.php";
    session_start();
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["courseid"]) && isset($_SESSION["userid"])){
        $dir = "file";
        $courseid = $_SESSION["courseid"];
        $userid = $_SESSION["userid"];
        $fileid = $_GET["fileid"];
        $result = fileUtil::getFile($userid,$courseid,$fileid);
        if (isset($result["path"])){
            $path = $result["path"];
            $size = $result["size"];
            $name = $result["name"];
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . $size);
            header('Content-Disposition: attachment; filename=' . basename($path).PHP_EOL);
            readfile("$dir/$path");
            exit();
        }else{
            die();
        }
    }

}