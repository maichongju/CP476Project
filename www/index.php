<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If user try to logout
    if (isset($_GET["logout"]) && $_GET["logout"] === "true" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        unset($_GET["logout"]);
        $_SESSION = null;
        session_destroy();
        header("index.php");
    }
}

require_once "util/user.php";

$username = "ERROR";
if (isset($_SESSION["loggedin"])) {
    $user = unserialize($_SESSION["user"]);
    $username = $user->getUsername();
}

?>
<!doctype html>
<html lang="en">
<title>CP476 Prject</title>

<head>
    <link href="css/project.css" rel="stylesheet">
</head>

<body class="blackground">
<div id="main-container">
    <div id="nav-block">
        <div id="nav-title">
        </div>
        <div id="nav-main">

            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                <div class="menu-dropdown" id="nav-main-account-dropdown">
                    <button id="nav-main-account-drop-down-button"><?php echo $username ?></button>
                    <div class="menu-dropdown-content" id="nav-main-dropdown-content">
                        <a href="account.php">Account Detail</a>
                        <a href="?logout=true" id="nav-logout">Log out</a>
                    </div>
                </div>
                <a href="#">My Panel</a>
            <?php else: ?>
                <a href="login.php">Log in</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>

    </div>
</div>
<br>
<div id = "main-intro-div">
    <p id = "main-page-intro">
        <br>
        Greetings! Students!
        <br>
        Thanks for choosing 麦辣鸡腿堡 learning machine!
        <br>
        <br>
    </p>
</div>
<div id="-instruction-container" class="instruction">
    <h1>Student's instruction</h1>
    <p id="main-instruction" class="instruction-detail">
        <br>
        To get started:
        <br>
        Login if you have an account, if you don't, click sign up.
        <br>
        Select courses and review the document your instructor post.
        <br>
        And you are ready to go!
        <br>
    </p>
</div>
<div id="teacher-instruction" class="instruction">
    <h2>Teacher's instruction</h2>
    <p class="instruction-detail">
        <br>
        Click login if you already have an account!
        <br>
        If you don't, click sign up for registration.
        <br>
        And send us your certificate of teaching for the course you are providing.
        <br>
        You are ready to start mentoring!
        <br>

    </p>
</div>
<div id ="copyright">
    <h3>Copy right reserve to 麦辣鸡腿堡 and 板烧鸡腿堡©</h3>
</div>
</body>


<script src="js/index.js"></script>

</html>
