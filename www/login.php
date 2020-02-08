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
        }else{
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
    <link href="css/project.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
</head>

<body>
<div id="div-login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form-login">
        <div>
            <p class="form-title">Log in</p>
            <p>Username</p>
            <input type="text" name="username" placeholder="Username" required>
            <p>Password</p>
            <input type="password" name="password" placeholder="Password" , required>
            <?php if ($error_msg !== null) {
                echo "<p class=\"form-error-msg\">" . $error_msg . "</p>";
            } ?>
            <input type="submit" class="form-submit">
            <p id="sign-up-hint">Don't have an account? Sign up <a href="signup.php">here</a></p>
        </div>

    </form>
</div>


</body>

</html>
