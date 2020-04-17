<?php
require_once "util/pageInitial.php";
require_once "util/courseUtil.php";
require_once "util/errorMsg.php";
// Get all the courses for the person if there is no course id attach
if (!isset($_GET["id"])) {
    $course = courseUtil::getCourses($_SESSION["userid"]);
} else {

}
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/header.php" ?>
    <link href="css/project.css" rel="stylesheet">
    <title>Course</title>
</head>
<!--<body>-->
<?php //require_once "topbar.php" ?>
<!--<div>-->
<!--    --><?php //require_once "sidebar.php" ?>
<!--    <div class="main-content">-->
<!--        <div class="items">-->
<!--            <header class="file-title">assignment1</header>-->
<!--            <img class="file-icon" src="images/icon-word.png">-->
<!--            <div class="file-comment">-->
<!--                <p>due next week</p>-->
<!--            </div>-->
<!--            <div class="file-but-containor">-->
<!--                <button class="file-but">Preview</button>-->
<!---->
<!--                <button class="file-but">Download</button>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--        <div class="items">-->
<!--            <header class="file-title">assignment2</header>-->
<!--            <img class="file-icon" src="images/icon-word.png">-->
<!--            <div class="file-comment">-->
<!--                <p>haven't posted week</p>-->
<!--            </div>-->
<!--            <div class="file-but-containor">-->
<!--                <button class="file-but">Preview</button>-->
<!---->
<!--                <button class="file-but">Download</button>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--        <div class="items">-->
<!--            <header class="file-title">lecture1</header>-->
<!--            <img class="file-icon" src="images/icon-word.png">-->
<!--            <div class="file-comment">-->
<!--                <p>will be updated</p>-->
<!--            </div>-->
<!--            <div class="file-but-containor">-->
<!--                <button class="file-but">Preview</button>-->
<!---->
<!--                <button class="file-but">Download</button>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<!---->
<!--</div>-->
<!--</div>-->

<div class="container">
    <div class="row">
        <!-- top bar -->
        <?php require_once "topbar.php" ?>
    </div>
    <div class="row mt-3">
        <!--side nav bar -->
        <?php require_once "sidebar.php" ?>

        <div class="col-sm-9 col-md-10 col-lg-10 mt-3">
            <?php if (isset($course)) {
                $course_size = count($course);
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
                            <a class="col-md-6 course-link" href="<?php echo "#?id=" . $course[$index]["id"] ?>">
                                <div class="card">
                                    <img class="card-img-top" src="images/default-thumbnail.jpg" alt="thumbnail">
                                    <div class="card-body">
                                        <h5 class="card-text"><?php echo strtoupper($course[$index]["id"]) . " - " . $course[$index]["name"] ?>
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
                            <a class="col-md-6 course-link" href="<?php echo "#?id=" . $course[$index]["id"] ?>">
                                <div class="card">
                                    <img class="card-img-top" src="images/default-thumbnail.jpg" alt="thumbnail">
                                    <div class="card-body">
                                        <h5 class="card-text"><?php echo strtoupper($course[$index]["id"]) . " - " . $course[$index]["name"] ?>
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }

                }

            } ?>


            <!--            <div class="row">-->
            <!--                <a class="col-md-6 course-link" href="#">-->
            <!--                    <div class="card">-->
            <!--                        <img class="card-img-top" src="images/default-thumbnail.jpg" alt="thumbnail">-->
            <!--                        <div class="card-body">-->
            <!--                            <h3 class="card-text">Testing title</h3>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </a>-->
            <!--                <a class="col-md-6" href="#">-->
            <!--                    <div class="card">-->
            <!--                        <img class="card-img-top" src="images/default-thumbnail.jpg" alt="thumbnail">-->
            <!--                        <div class="card-body">-->
            <!--                            <h3 class="card-text">Testing title</h3>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </a>-->
            <!--            </div>-->


        </div>
    </div>
</div>
