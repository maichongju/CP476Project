<?php

if (!empty($_POST)) {
    require_once "util/fileUtil.php";
    require_once "util/errorMsg.php";
    session_start();

    $dir = "file";
    $result_ = array("result" =>false);
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["courseid"]) && isset($_SESSION["userid"])) {
        $userid = $_SESSION["userid"];
        $courseid = $_SESSION["courseid"];
        $name = $_POST["name"];
        $path = "file/" . $_FILES["file"]["name"];
        $desc = $_POST["description"];
        $size = $_FILES["file"]["size"];
        $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $file_hash = hash_file("md5", $_FILES["file"]["tmp_name"]);
        $result = fileUtil::upload($userid, $courseid, $name, $desc, $path, $size, $file_hash, $ext);
        if (isset($result["result"])){
            if (move_uploaded_file($_FILES["file"]["tmp_name"],"$dir/$name")){
                $result_["result"] = true;
                $result_["msg"] = ErrorMsg::FILE_FILE_UPLOAD_SUCCESS;
            }else{
                $result_["error"] = ErrorMsg::FILE_FILE_UPLOAD_ERROR;
            }
        }else if (isset($result["error"])){
            $result_["error"] = $result["error"];
        }else if (isset($result["warning"])){
            $result_["warning"] = $result["warning"];
        }

        echo json_encode($result_);
    }


}