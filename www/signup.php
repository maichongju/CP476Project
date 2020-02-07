<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: index.php");
    exit;
}


require_once "util/userUtil.php";
$error_msg =null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    try{
        $user = userUtil::Signup($username,password_hash($password,PASSWORD_BCRYPT));
        if ($user === null)
            // if user is null it means it did not create successed 
            $error_msg = "Username aleady exist.";
        else{
            // login success
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = serialize($user);
            
            header("location: index.php");
        }
    }catch(Exception $e){
        $error_msg = $e->getMessage();
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form-signup">
            <div>
                <p class="form-title">Sign Up</p>
                <p>Username</p>
                <input type="text" name="username" placeholder="Username" required>
                <p>Password</p>
                <input type="password" name="password" placeholder="Password" required>
                <p>Confirm Password</p>
                <input type="password" name="cpassword" placeholder="Confirm Password" required>
                <?php if ($error_msg !== null) {echo "<p class=\"form-error-msg\">" .$error_msg ."</p>";} ?>
                <input type="submit" class="form-submit">
                <p id="sign-up-hint">Already have an account? Sign in <a href="login.php">here</a></p>
            </div>

        </form>
    </div>


</body>
<script src="/js/form.js"></script>

</html>
