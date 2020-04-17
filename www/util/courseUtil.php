<?php
require_once "dbConnect.php";

class courseUtil
{
    public static function getCourses($userid)
    {
        $courses = null;
        $database = new DbConnect();
        $conn = $database->getConnection();

        $sql = "select id, name from user_course left join course c on user_course.courseid = c.id where userid = ? order by id;";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(1, $userid);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            $courses = array();
            if (count($result) > 0) {
                foreach ($result as $item) {
                    array_push($courses, $item);
                }
            }
        }
        $database->closeConnection();
        return $courses;
    }

    /**
     *
     * @param $userid
     * @param $courseid
     * @return array if there is server error then it will return null. Struct ["error": set if there is error,["files": [file]]]
     */
    public static function getCourse($userid, $courseid)
    {
        $course = null;
        $database = new DbConnect();
        $conn = $database->getConnection();

        $sql_CheckCourse = "select * from course where id = ?;";
        $sql_Authenticate = "select * from user_course where userid = ? and courseid = ?;";
        $sql = "select id , name, description, size, extension  from file where courseId = ?;";
        $stmt = $conn->prepare($sql_CheckCourse);
        $stmt->bindParam(1,$courseid);
        if ($stmt->execute()){
            if ($stmt->rowCount() === 1){
                $stmt = $conn->prepare($sql_Authenticate);
                $stmt->bindParam(1,$userid);
                $stmt->bindParam(2,$courseid);
                if ($stmt->execute()){
                    // There is 1 match
                    if ($stmt->rowCount() === 1){
                        $stmt = $conn->prepare($sql);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $stmt->bindParam(1,$courseid);
                        if ($stmt->execute()){
                            $result = $stmt->fetchAll();
                            $course = array("files" => array());
                            // Add each result to the result
                            foreach ($result as $item){
                                array_push($course["files"],$item);
                            }
                        }
                    }else{
                        $course = array("error" => ErrorMsg::COURSE_AUTHENTICATE_ERROR);
                    }
                }
            }else{
                $course = array("error" => ErrorMsg::COURSE_COURSE_NOT_FOUND_ERROR);
            }

        }

        $database->closeConnection();
        return $course;
    }
}