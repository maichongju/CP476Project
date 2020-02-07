<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: index.php");
    exit;
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
                <p class="error-message"> </p>
                <input type="submit" class="form-submit">
                <p id="sign-up-hint">Don't have an account? Sign up <a href="signup.php">here</a></p>
            </div>

        </form>
    </div>


</body>

</html>
