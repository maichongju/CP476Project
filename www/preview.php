<?php
require_once "include/pageInitial.php";
require_once "util/fileUtil.php";

?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once "include/header.php" ?>
    <link href="css/project.css" rel="stylesheet">
    <title>Preview</title>
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
            <div class="embed-responsive embed-responsive-1by1">
                <iframe src="file/cp476/test2.pdf" class="embed-responsive-item" width="100%" height="100%">
                    You brower does not support this
                </iframe>
            </div>
        </div>
    </div>
</div>

