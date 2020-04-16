<?php
session_start();

// Check if it is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]){
    if (isset($_SESSION["user"])){
        $user = unserialize($_SESSION["user"]);
        // Log in success
    }else{
        // something went wrong. Logout and redirect back to login page
        setcookie("ERROR",errorMsg::SESSION_EXPIRED_ERROR);
        $_SESSION["loggedin"] = false;
        header("location: login.php");
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <link href="css/project.css" rel="stylesheet">
</head>
<body>
<?php require_once "topbar.php" ?>
<div>
    <?php require_once "sidebar.php" ?>
    <div class="main-content">
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

    </div>

</div>
</div>


</body>