<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}


require_once "util/userUtil.php";
require_once "util/errorMsg.php";
$error_msg = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $user = userUtil::Signup($username, password_hash($password, PASSWORD_BCRYPT));
        if ($user === null)
            // if user is null it means it did not create successed
            $error_msg = ErrorMsg::DATABASE_USERNAME_EXIST_ERROR;
        else {
            // login success
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = serialize($user);

            header("location: index.php");
        }
    } catch (PDOException $e) {
        if ($e->getCode() === 1045) {
            $error_msg = ErrorMsg::DATABASE_CONNECT_ERROR;
        } else if ($e->getCode() === "23000") {
            $error_msg = ErrorMsg::DATABASE_USERNAME_EXIST_ERROR;
        } else {
            $error_msg = $e->getMessage();
        }

    }
}


?>
<!doctype html>
<html>

<head>
    <title>Sign up</title>
    <?php include "include/header.php" ?>
    <link href="css/form.css" rel="stylesheet">
</head>

<body>
<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">

                    <h1 class="display-4 py-2 text-truncate text-white">Sign Up</h1>
                    <div class="px-2">
                        <form action="signup.php" method="post" class="justify-content-center" id="form-signup">
                            <div class="form-group">
                                <label class="sr-only" for="usernameinput">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="oi oi-person" title="person"
                                                                         aria-hidden="true"></span></span>
                                    </div>
                                    <input id="usernameinput" name="username" type="text" class="form-control"
                                           placeholder="Username" required>
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
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="cpasswordinput">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><span class="oi oi-lock-locked" title="lock-locked"
                                                                         aria-hidden="true" style="width: 16px"></span></span>
                                    </div>
                                    <input id="cpasswordinput" name="cpassword" type="password" class="form-control"
                                           placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="form-group error-msg-group">
                                <?php if ($error_msg !== null) {
                                    echo "<h5 class=\"form-text text-danger error-msg\">" . $error_msg . "</h5>";
                                } ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            <p class="form-text text-white mt-3">Already have an account? <a href="login.php">Login here </a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>


<script src="js/form.js"></script>

</html>
