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
        <div class="account-tab">
            <button class="account-tablinks" onclick="openAccountTab(event,'main')" id="account-tab-default"></button>
            <button class="account-tablinks" onclick="openAccountTab(event,'change-password')"></button>


        </div>

        <div id="main" class="account-tab-content">
            Main

        </div>
        <div id="change-password" class="account-tab-content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                  id="form-change-password">
                <h2 class="title-2">Change Password</h2>
                <div class="break-line"></div>
                <p>Old Password</p>
                <input type="password" name="old-password">
                <p>New Password</p>
                <input type="password" name="new-password">
                <p>Confirm password</p>
                <input type="password" name="confirm-password"><br>

                <button type="submit">Submit</button>
            </form>
        </div>


    </div>


</div>

</body>
<script src="js/functions.js"></script>

</html>
