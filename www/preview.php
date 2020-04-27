<?php
require_once "include/pageInitial.php";
require_once "util/fileUtil.php";

if (isset($_SESSION["loggedin"]) && isset($_SESSION["courseid"]) && isset($_SESSION["userid"]) && isset($_GET["id"])) {
    $courseid = $_SESSION["courseid"];
    $userid = $_SESSION["userid"];
    $fileid = $_GET["id"];
    $file = fileUtil::getFile($userid, $courseid, $fileid);
}
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

        <div class="col-sm-9 col-md-10 col-lg-10 mt-3 mb-3">
            <?php if (isset($file)) { ?>
                <h3> <?php echo $file["name"] ?></h3>
                <p><?php echo $file["description"] ?> </p>
                <?php if (strtolower($file["extension"]) == 'pdf') {
                    ?>
                    <div class="embed-responsive embed-responsive-1by1">
                        <iframe src="file/<?php echo $file["path"] ?>" class="embed-responsive-item">
                            Sorry you browser does not support pdf preview
                        </iframe>
                    </div>
                <?php } elseif (strtolower($file["extension"]) == 'txt') { ?>
                    <h5>Preview</h5>
                    <?php
                    $path = $file["path"];
                    if (file_exists("file/$path")) { ?>
                        <pre><?php echo file_get_contents("file/$path", true) ?></pre>
                    <?php } else { ?>
                        <div class="alert alert-warning" role="alert">
                            Sorry, this file can not be preview :(
                        </div>
                    <?php }
                } else { ?>
                    <div class="alert alert-warning" role="alert">
                        Sorry, this file can not be preview :(
                    </div>
                <?php }
            } else { ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Preview Failed.</strong> Please try again later
                </div>

            <?php } ?>
        </div>
    </div>
</div>

