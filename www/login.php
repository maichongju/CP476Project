<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$error_msg = null;

require_once "util/userUtil.php";
require_once "util/user.php";
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
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["userid"] = $user->getUserId();
            $_SESSION["userrole"] = $user->getRole();
            $expire_time = time() + 60 * 60 * 24 * 30;
            setcookie("username",$username,$expire_time);
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
// Try to get username form cookie
if (isset($_COOKIE["username"])) {
    $username = $_COOKIE["username"];
}

if (isset($_COOKIE["ERROR"])){
    $error_msg = $_COOKIE["ERROR"];
    setcookie("ERROR","",time()-3600);
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
                                           placeholder="Username" <?php if (isset($username)) echo "value='" . $username . "'" ?>>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="passwordinput">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="oi oi-lock-locked" title="lock-locked"
                                                                         aria-hidden="true" style="width: 16px"></span></span>
                                    </div>
                                    <input id="passwordinput" name="password" type="password" class="form-control"
                                           placeholder="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <?php if ($error_msg !== null) {
                                    echo "<h5 class=\"form-text text-danger error-msg\">" . $error_msg . "</h5>";
                                } ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>

                            <p class="form-text text-white mt-3">Don't have an account? <a href="signup.php">Sign up
                                    here</a>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>


</html>
