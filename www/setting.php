<?php
require_once "include/pageInitial.php";
require_once "util/userUtil.php";

if (!empty($_POST) && isset($_POST["p"]) && isset($_SESSION["userid"])) {
    $p = $_POST["p"];
    $id = $_SESSION["userid"];
    $status = userUtil::changePassword($id, $p);

}
?>

<html lang="en">

<head>
    <?php require_once "include/header.php" ?>
    <!--    <link rel="stylesheet" href="css/project.css">-->
    <title>My Account</title>

</head>
<div class="container">
    <div class="row">
        <!-- top bar -->
        <?php require_once "topbar.php" ?>
    </div>
    <div class="row mt-3">
        <!--side nav bar -->
        <?php require_once "sidebar.php" ?>

        <div class="col-sm-9 col-md-10 col-lg-10 mt-3">
            <div id="msg">
                <?php if (isset($status)) {
                    if ($status) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            Password Updated!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-danger" role="alert">
                            Password Updated failed!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php }
                } ?>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Change Password</h4>
                    <form id="changePassword" method="post" action="setting.php">
                        <div class="form-group">
                            <label for="newp">New Password</label>
                            <input type="password" class="form-control" id="p" name="p" required>
                        </div>
                        <div class="form-group">
                            <label for="newpr">Repeat New Password</label>
                            <input type="password" class="form-control" id="pr" required>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">Change Password</button>
                    </form>
                </div>

            </div>


        </div>
    </div>
</div>

<script src="js/setting.js" type="text/javascript"></script>
</html>
