<?php
session_start();
?>

<html lang="en">

<head>
    <link rel="stylesheet" href="css/project.css">
    <title>My Account</title>

</head>

<body>

<!-- top bar -->
<?php require_once "topbar.php" ?>

<div>
    <!--side nav bar -->
    <?php require_once "sidebar.php" ?>

    <div class="main-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form-change-password">
            <h2 class="title-2">Change Password</h2>
            <div class="break-line"></div>
            <label>
                Old Password
                <input type="password" name="old-password">
            </label>


        </form>



    </div>


</div>

</body>


</html>
