<?php

if (!empty($_POST)) {
    require_once "util/fileUtil.php";
    session_start();
    $result = array("result" => false);
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["courseid"]) && isset($_SESSION["userid"]) && isset($_POST["fileid"])) {
        $r = fileUtil::delete($_SESSION["userid"], $_SESSION["courseid"], $_POST["fileid"]);
        if ($r["result"]) {
            $result["result"] = true;
            $path = $r["path"];
            $courseid = $_SESSION["courseid"];
            $fullpath = "file/$path";
            if (file_exists($fullpath)) {
                unlink($fullpath);
            }
        }
    }
    echo json_encode($result);
}