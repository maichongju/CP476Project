<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$error_msg = null;

require_once "util/userUtil.php";
require_once "util/errorMsg.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $user = userUtil::Login($username, $password);
        if ($user === null) {
            $error_msg = ErrorMsg::DATABASE_USERNAME_PASSWORD_ERROR;
        } else {
            // login success
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = serialize($user);

            header("location: index.php");
        }
    } catch (PDOException $e) {
        if ($e->getCode() === 1045) {
            $error_msg = ErrorMsg::DATABASE_CONNECT_ERROR;
        } else {
            $error_msg = $e->getMessage();
        }
    }
}

?>
<!doctype html>
<html>

<head>
    <title>Log In</title>
    <?php include "include/header.php" ?>
    <link href="css/form.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>


<!--        <form class="form mx-auto" action="login.php" method="post">-->
<!--            <div>-->
<!--                <p class="form-title">Log in</p>-->
<!--                <p>Username</p>-->
<!--                <input type="text" name="username" placeholder="Username" required>-->
<!--                <p>Password</p>-->
<!--                <input type="password" name="password" placeholder="Password" , required>-->
<!--                --><?php //if ($error_msg !== null) {
//                    echo "<p class=\"form-error-msg\">" . $error_msg . "</p>";
//                } ?>
<!--                <input type="submit" class="form-submit">-->
<!--                <p id="sign-up-hint">Don't have an account? Sign up <a href="signup.php">here</a></p>-->
<!--            </div>-->
<!---->
<!--        </form>-->
<body>
<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">

                    <h1 class="display-4 py-2 text-truncate text-white">Log in</h1>
                    <div class="px-2">
                        <form action="login.php" method="post" class="justify-content-center">
                            <div class="form-group">
                                <label class="sr-only" for="usernameinput">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="oi oi-person" title="person"
                                                                         aria-hidden="true"></span></span>
                                    </div>
                                    <input id="usernameinput" name="username" type="text" class="form-control"
                                           placeholder="Username">
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="passwordinput">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="oi oi-lock-locked" title="lock-locked"
                                                                         aria-hidden="true"></span></span>
                                    </div>
                                    <input id="passwordinput" name="password" type="password" class="form-control"
                                           placeholder="password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>


</html>
