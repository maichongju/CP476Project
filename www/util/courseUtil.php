<?php
require_once "dbConnect.php";

class courseUtil
{
    public static function getCourses($userid){
        $courses = null;
        $database = new DbConnect();
        $conn = $database->getConnection();

        $sql = "select id, name from user_course left join course c on user_course.courseid = c.id where userid = ? order by id;";
        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->bindParam(1,$userid);
        if ($stmt->execute()){
            $result = $stmt->fetchAll();
            if (count($result) > 0){
                $courses = array();
                foreach ($result as $item){
                    array_push($courses,$item);
                }
            }
        }
        return $courses;
    }
}