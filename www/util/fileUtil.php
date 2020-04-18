<?php
require_once "dbConnect.php";
require_once "errorMsg.php";

class fileUtil
{
    public static function convertFileSize($size)
    {
        $size = $size / 1024;
        $unit = array("K", "M", "G");
        foreach ($unit as $item) {

            if ($size > 1000) {
                $size = $size / 1024;
            } else {
                break;
            }
        }
        return number_format($size, 2, '.', '') . " " . $item;
    }

    public static function upload($userid, $courseid, $name, $desc, $path, $size, $hash, $extension)
    {
        $result = null;
        $database = new DbConnect();
        $conn = $database->getConnection();

        $sql_CheckCourse = "select * from course where id = ?;";
        $sql_Authenticate = "select * from user_course where userid = ? and courseid = ?;";
        $sql_FileExist = "select count(id) as number from file where courseId = ? and hash = ?;";
        $sql_upload = "insert into file (name,description,path,size,hash,extension,courseId) values (?,?,?,?,?,?,?);";

        // Check Course exist
        $stmt = $conn->prepare($sql_CheckCourse);
        $stmt->bindParam(1, $courseid);
        if ($stmt->execute()) {
            if ($stmt->rowCount() === 1) {
                // Check if user Authenticate
                $stmt = $conn->prepare($sql_Authenticate);
                $stmt->bindParam(1, $userid);
                $stmt->bindParam(2, $courseid);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() === 1) {
                        $stmt = $conn->prepare($sql_FileExist);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $stmt->bindParam(1, $courseid);
                        $stmt->bindParam(2, $hash);
                        if ($stmt->execute()) {
                            if ($stmt->fetchAll()[0]["number"] == 0) {
                                $stmt = $conn->prepare($sql_upload);
                                $stmt->bindParam(1, $name);
                                $stmt->bindParam(2, $desc);
                                $stmt->bindParam(3, $path);
                                $stmt->bindParam(4, $size);
                                $stmt->bindParam(5, $hash);
                                $stmt->bindParam(6, $extension);
                                $stmt->bindParam(7, $courseid);
                                if ($stmt->execute()) {
                                    $result = array("result" => true);
                                }
                            }else{
                                $result = array("warning" => ErrorMsg::FILE_FILE_EXIST_WARNING);
                            }
                        }
                    } else {
                        $result = array("error" => ErrorMsg::COURSE_AUTHENTICATE_ERROR);
                    }
                }
            } else {
                $$result = array("error" => ErrorMsg::COURSE_COURSE_NOT_FOUND_ERROR);
            }
        }
        $database->closeConnection();
        return $result;
    }

    public static function delete($userid,$courseid,$hash){
        $result = false;

        $database = new DbConnect();
        $conn = $database->getConnection();


        $sql_Authenticate = "select count(userid) as result from user_course where userid = ? and courseid = ?;";
        $sql_delete = "delete from file where hash = ? and courseId = ?";

        $stmt = $conn->prepare($sql_Authenticate);
        $stmt->bindParam(1,$userid);
        $stmt->bindParam(2,$courseid);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Check if user is authenticate
        if ($stmt->execute()){
            $stmt = $conn->prepare($sql_delete);
            $stmt->bindParam(1,$hash);
            $stmt->bindParam(2,$courseid);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()){
                $result = true;
            }
        }

        $database->closeConnection();
        return $result;
    }
}