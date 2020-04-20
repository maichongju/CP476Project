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
        $path = "$courseid/$path";
        $database = new DbConnect();
        $conn = $database->getConnection();

        $sql_CheckCourse = "select * from course where id = ?;";
        $sql_Authenticate = "select * from user_course left join user on user_course.userid = user.id where userid = ? and courseid = ? and role <> 2;";
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
                            } else {
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

    public static function delete($userid, $courseid, $fileid)
    {
        $result = array("result" => false);

        $database = new DbConnect();
        $conn = $database->getConnection();


        $sql_Authenticate = "select count(userid) as result from user_course left join user on user_course.userid = user.id where userid = ? and courseid = ? and role <> 2;";
        $sql_CheckFileExist = "select path from file where id = ?";
        $sql_delete = "delete from file where id = ? and courseId = ?";

        $stmt = $conn->prepare($sql_Authenticate);
        $stmt->bindParam(1, $userid);
        $stmt->bindParam(2, $courseid);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // Check if user is authenticate
        if ($stmt->execute()) {
            $stmt = $conn->prepare($sql_CheckFileExist);
            $stmt->bindParam(1, $fileid);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $result["path"] = $stmt->fetchAll()[0]["path"];

                    $stmt = $conn->prepare($sql_delete);
                    $stmt->bindParam(1, $fileid);
                    $stmt->bindParam(2, $courseid);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if ($stmt->execute()) {
                        $result["result"] = true;
                    }
                }


            }

        }

        $database->closeConnection();
        return $result;
    }

    public static function getFile($userid, $courseid, $fileid)
    {
        $result = array();
        $database = new DbConnect();
        $conn = $database->getConnection();

        $sql = "select file.id, file.description,extension, path,size,file.name as name from file join course c on file.courseId = c.id join user_course uc on c.id = uc.courseid where userid = ? and file.courseId = ? and file.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $userid);
        $stmt->bindParam(2, $courseid);
        $stmt->bindParam(3, $fileid);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $result = $stmt->fetchAll()[0];
            } else {
                $result["error"] = ErrorMsg::FILE_AUTHENTICATE_ERROR;
            }
        } else {
            $result["error"] = ErrorMsg::FILE_FILE_DOWNLOAD_FAIL;
        }
        $database->closeConnection();
        return $result;
    }

    /**
     * @param $ext string extension of the file
     * @return bool true if it is support preview
     */
    public static function previewValid($ext)
    {
        $vaildExt = array("pdf", "txt");
        return in_array(strtolower($ext), $vaildExt);
    }
}