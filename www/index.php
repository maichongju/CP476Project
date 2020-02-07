<?php
    session_start();

?>
<!doctype html>
<html lang="en">
<title>CP476 Prject</title>

<head>
    <link href="css/project.css" rel="stylesheet">
</head>

<body>
    <div id="main-container">
        <div id="nav-block">
            <div id="nav-title">
            </div>
            <nav id="nav-main">
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                <a href="?logout=true">Log out</a>
                <?php else: ?>
                <a href="login.php">Log in</a>
                <a href="signup.php">Sign Up</a>
                <?php endif; ?>
            </nav>
        </div>

    </div>

</body>

<script src="/js/project.js"></script>

</html>
