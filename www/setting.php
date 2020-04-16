<?php
require_once "util/pageInitial.php"
?>

<html lang="en">

<head>
    <?php include "include/header.php" ?>
<!--    <link rel="stylesheet" href="css/project.css">-->
    <title>My Account</title>

</head>
<div class="container">
    <div class="row">
        <!-- top bar -->
        <?php include "topbar.php" ?>
    </div>
    <div class="row mt-3">
        <!--side nav bar -->
        <?php require_once "sidebar.php" ?>

        <div class="col-sm-9 col-md-10 col-lg-10">
            <div class="">
                <button class="account-tablinks" onclick="openAccountTab(event,'main')" id="account-tab-default">Main
                </button>
                <button class="account-tablinks" onclick="openAccountTab(event,'change-password')">Change Password
                </button>


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
</div>

<script src="js/functions.js" type="text/javascript"></script>

</html>
