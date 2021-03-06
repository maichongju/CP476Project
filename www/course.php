<?php
require_once "include/pageInitial.php";
require_once "util/userUtil.php";
require_once "util/courseUtil.php";
require_once "util/fileUtil.php";
require_once "util/errorMsg.php";
require_once "util/flickr.php";

// Get all the courses for the person if there is no course id attach
if (!isset($_GET["id"])) {
    $courses = courseUtil::getCourses($_SESSION["userid"]);
} else {
    $course = courseUtil::getCourse($_SESSION["userid"], $_GET["id"]);
}

unset($_SESSION["courseid"]);
unset($_SESSION["coursename"]);

$icon_ext = array(
    "pdf" => "icons8-pdf.png",
    "excel" => "icons8-excel.png",
    "ppt" => "icons8-ppt.png",
    "other" => "icons8-file.png",
    "txt" => "icons8-txt.png",
    "word" => "icons8-word.png"
);

function getFileIcon($ext){
    global  $icon_ext;
    $ext = strtolower($ext);
    $result = "images\icon\\";
    if (array_key_exists($ext, $icon_ext)){
        $result.= $icon_ext[$ext];
    }else{
        if ($ext == "ppt" || $ext == "pptx"){
            $result .= $icon_ext["ppt"];
        }elseif ($ext == "doc" || $ext == "docx"){
            $result .= $icon_ext["word"];
        }elseif ($ext == "xls" || $ext == "xlsx"){
            $result .= $icon_ext["excel"];
        }else{
            $result .= $icon_ext["other"];
        }
    }
    return $result;
}

$photourl = flickrUtil::getPhoto();

if (!isset($photourl)){
    $photourl = "images/default-thumbnail.jpg";
}


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
                   class="btn btn-outline-info mb-3 col-lg-2">Upload</a>
                <div class="alert alert-info mb-3 " role="alert">
                    Current preview only support pdf and txt file
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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
                                    <img class="card-img-top" src="<?php echo $photourl?>" alt="thumbnail">
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
                                    <img class="card-img-top" src="<?php echo $photourl?>" alt="thumbnail">
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

            }
            // Individual course display
            else {
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
                                        <p class="card-title h4"><img width="36px" height="36px"
                                                                      src="<?php echo getFileIcon($file["extension"]) ?>" alt=""
                                                                      title="<?php echo $file["extension"] ?>"><span
                                                    class="text-truncate mx-2"><?php echo $file["name"] ?></span>
                                        </p>
                                    </div>
                                    <div class="card-block card-body">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <p class="card-title"> <span
                                                            class="card-subtitle h6 small text-muted"><?php echo fileUtil::convertFileSize($file["size"]) ?></span>
                                                </p>
                                                <p class="card-text text-truncate"><?php echo $file["description"] ?></p>
                                            </div>
                                            <div class="col-lg-3">
                                                <a class="btn btn-outline-primary btn-block <?php if (!fileUtil::previewValid($file["extension"])) echo "disabled" ?>"
                                                   role="button"
                                                   href="preview.php?id=<?php echo $file["id"] ?>"
                                                    <?php if (!fileUtil::previewValid($file["extension"])) echo "aria-disabled='true' tabindex='-1'" ?>
                                                >Preview</a>
                                                <a class="btn btn-outline-dark btn-block"
                                                        href=download.php?fileid=<?php echo $file["id"] ?> target="_blank">Download
                                                </a>
                                                <?php
                                                if ($_SESSION["userrole"] < 2) {
                                                    echo '<button class="btn btn-outline-danger btn-block delete-record-button"  value="' . $file["id"] . '">Delete</button>';
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
<script src="js/course.js"></script>