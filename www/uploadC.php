<?php

if (!empty($_POST)) {
    require_once "util/fileUtil.php";
    require_once "util/errorMsg.php";
    session_start();

    $dir = "file";
    $result_ = array("result" => false);
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["courseid"]) && isset($_SESSION["userid"])) {
        $userid = $_SESSION["userid"];
        $courseid = strtolower($_SESSION["courseid"]);
        $name = $_POST["name"];
        $filename = basename($_FILES["file"]["name"]);
        $path = "file/" . $_FILES["file"]["name"];
        $desc = $_POST["description"];
        $size = $_FILES["file"]["size"];
        $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $file_hash = hash_file("md5", $_FILES["file"]["tmp_name"]);
        if (!file_exists($dir)) {
            if (!mkdir($dir)) {
                $error = true;
                $result_["error"] = ErrorMsg::FILE_DIRECTORY_CREATE_ERROR;
            }
        }
        if (!isset($error)) {
            $result = fileUtil::upload($userid, $courseid, $name, $desc, $path, $size, $file_hash, $ext);
            if (isset($result["result"])) {
                // Make check if sub directory exist, if not create one
                if (!file_exists($dir/$courseid)){
                    mkdir($dir/$courseid);
                }
                if (move_uploaded_file($_FILES["file"]["tmp_name"], "$dir/$courseid/$filename")) {
                    $result_["result"] = true;
                    $result_["msg"] = ErrorMsg::FILE_FILE_UPLOAD_SUCCESS;
                } else {
                    fileUtil::delete($userid,$courseid,$file_hash);
                    $result_["error"] = ErrorMsg::FILE_FILE_UPLOAD_ERROR;
                }
            } else if (isset($result["error"])) {
                $result_["error"] = $result["error"];
            } else if (isset($result["warning"])) {
                $result_["warning"] = $result["warning"];
            }
        }


        echo json_encode($result_);
    }


}