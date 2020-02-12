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

<body class="index-page">
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

</body>


<script src="js/index.js"></script>

</html>
