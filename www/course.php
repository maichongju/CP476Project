<?php
require_once "include/pageInitial.php";
require_once "util/userUtil.php";
require_once "util/courseUtil.php";
require_once "util/fileUtil.php";
require_once "util/errorMsg.php";

// Get all the courses for the person if there is no course id attach
if (!isset($_GET["id"])) {
    $courses = courseUtil::getCourses($_SESSION["userid"]);
} else {
    $course = courseUtil::getCourse($_SESSION["userid"], $_GET["id"]);
}

unset($_SESSION["courseid"]);
unset($_SESSION["coursename"]);
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/header.php" ?>
    <link href="css/project.css" rel="stylesheet">
    <title>Course <?php
        if (isset($course) && !isset($course["error"])) {
            echo " - " . strtoupper($course["id"]) . " " . $course["name"];
        }
        ?></title>
</head>
<div class="container">
    <div class="row">
        <!-- top bar -->
        <?php require_once "topbar.php" ?>
    </div>
    <div class="row mt-3">
        <!--side nav bar -->
        <?php require_once "sidebar.php" ?>

        <div class="col-sm-9 col-md-10 col-lg-10 mt-3">
            <?php if (userUtil::isAdmin() && isset($course) && !isset($course["error"])) { ?>
                <a href="upload.php?id=<?php echo $course["id"] ?>"
                   class="btn btn-outline-info mb-3 col-lg-2 col-md-12">Upload</a>
            <?php }
            if (isset($courses)) {
                $course_size = count($courses);
                // display all courses
                if ($course_size === 0) {
                    ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo errorMsg::COURSE_EMPTY_COURSE_WARNING ?>
                    </div>

                    <?php
                } else {
                    $row = intdiv($course_size, 2);
                    $index = 0;
                    for ($i = 0; $i < $row; $i++) {
                        echo "<div class='row mb-3'>";
                        for ($j = 0; $j < 2; $j++) { ?>
                            <a class="col-md-6 course-link" href="<?php echo "?id=" . $courses[$index]["id"] ?>">
                                <div class="card">
                                    <img class="card-img-top" src="images/default-thumbnail.jpg" alt="thumbnail">
                                    <div class="card-body">
                                        <h5 class="card-text"><?php echo strtoupper($courses[$index]["id"]) . " - " . $courses[$index]["name"] ?>
                                        </h5>
                                    </div>
                                </div>
                            </a>

                            <?php
                            $index++;
                        }
                        echo "</div>";
                    }
                    if ($index < $course_size) { ?>
                        <div class="row mb-3">
                            <a class="col-md-6 course-link" href="<?php echo "?id=" . $courses[$index]["id"] ?>">
                                <div class="card">
                                    <img class="card-img-top" src="images/default-thumbnail.jpg" alt="thumbnail">
                                    <div class="card-body">
                                        <h5 class="card-text"><?php echo strtoupper($courses[$index]["id"]) . " - " . $courses[$index]["name"] ?>
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }

                }

            } else {
                $server_error = true;
                // Need to check if it is id exist
                if (isset($_GET["id"]) && isset($course)) {
                    if (isset($course["error"])) {
                        $errmsg = $course["error"];
                    } else {
                        $server_error = false;
                        $_SESSION["courseid"] = $course["id"];
                        $_SESSION["coursename"] = $course["name"];
                        if (count($course["files"]) == 0) {
                            ?>
                            <div class="alert alert-warning" role="alert">
                                <?php echo ErrorMsg::FILE_EMPTY_FILE_WARNING ?>
                            </div>
                            <?php
                        } else {
                            foreach ($course["files"] as $file) {
                                ?>
                                <div class="card mb-3">
                                    <div class="card-header ">
                                        <p class="card-title h4"><span
                                                    class="text-truncate"><?php echo $file["name"] ?></span>
                                        </p>
                                    </div>
                                    <div class="card-block card-body">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <p class="card-title"><img width="24px" height="24px"
                                                                           src="images/icon/icon-pdf.png" alt=""
                                                                           title="pdf"> <span
                                                            class="card-subtitle h6 small text-muted"><?php echo fileUtil::convertFileSize($file["size"]) ?></span>
                                                </p>
                                                <p class="card-text text-truncate"><?php echo $file["description"] ?></p>
                                            </div>
                                            <div class="col-lg-3">
                                                <a class="btn btn-outline-primary btn-block "
                                                   href="preview.php?id=<?php echo $file["id"] ?>">Preview</a>
                                                <button class="btn btn-outline-dark btn-block"
                                                        value="<?php echo $file["id"] ?>">Download
                                                </button>
                                                <?php
                                                if ($_SESSION["userrole"] < 2) {
                                                    echo '<button class="btn btn-outline-danger btn-block" id="delete-record" value="' . $file["id"] . '">Delete</button>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }

                    }
                }
                if ($server_error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (isset($errmsg)) {
                            echo $errmsg;
                        } else {
                            echo ErrorMsg::DATABASE_CONNECT_ERROR;
                        } ?>
                    </div>
                    <?php
                }
                ?>
                <?php
            } ?>

        </div>
    </div>
</div>