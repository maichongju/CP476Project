<?php
session_start();


require_once "util/user.php";

$username = "ERROR";
if (isset($_SESSION["loggedin"])) {
    if (!isset($_SESSION["username"])) {
        header("location: logout.php");
    } else {
        $username = $_SESSION["username"];
    }

}

?>
<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/header.php" ?>
    <title>CP476 Prject</title>
</head>


<div class="container">
    <div class="row">
        <nav class="navbar navbar-light bg-light w-100">
            <div class="col-md-8">
                <img class="img-fluid" src="images/logo.png" alt="">
            </div>
            <div class="col-md-4">
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                    <div class="nav-item dropdown float-right mr-3">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false" href=""><?php echo $username ?></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="course.php">Courses</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">logout</a>
                        </div>
                    </div>

                <?php else: ?>
                <ul class="nav float-right">
                    <li class="nav-item mr-3">
                        <a class="btn btn-outline-primary" href="login.php">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary" href="signup.php">Sign Up</a>
                    </li>
                </ul>


                <?php endif; ?>
            </div>
        </nav>
    </div>
    <div class="row">
        <!--        TODO code in here!-->
    </div>
</div>


<!--</div>-->
<!--</div>-->
<!--<br>-->
<!--<div id="main-intro-div">-->
<!--    <p id="main-page-intro">-->
<!--        <br>-->
<!--        Greetings! Students!-->
<!--        <br>-->
<!--        Thanks for choosing 麦辣鸡腿堡 learning machine!-->
<!--        <br>-->
<!--        <br>-->
<!--    </p>-->
<!--</div>-->
<!--<div id="-instruction-container" class="instruction">-->
<!--    <h1>Student's instruction</h1>-->
<!--    <p id="main-instruction" class="instruction-detail">-->
<!--        <br>-->
<!--        To get started:-->
<!--        <br>-->
<!--        Login if you have an account, if you don't, click sign up.-->
<!--        <br>-->
<!--        Select courses and review the document your instructor post.-->
<!--        <br>-->
<!--        And you are ready to go!-->
<!--        <br>-->
<!--    </p>-->
<!--</div>-->
<!--<div id="teacher-instruction" class="instruction">-->
<!--    <h2>Teacher's instruction</h2>-->
<!--    <p class="instruction-detail">-->
<!--        <br>-->
<!--        Click login if you already have an account!-->
<!--        <br>-->
<!--        If you don't, click sign up for registration.-->
<!--        <br>-->
<!--        And send us your certificate of teaching for the course you are providing.-->
<!--        <br>-->
<!--        You are ready to start mentoring!-->
<!--        <br>-->
<!---->
<!--    </p>-->
<!--</div>-->
<!--<div id="copyright">-->
<!--    <h3>Copy right reserve to 麦辣鸡腿堡 and 板烧鸡腿堡©</h3>-->
<!--</div>-->


<script src="js/index.js"></script>

</html>
