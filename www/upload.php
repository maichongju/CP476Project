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

            <form>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload-file-input">
                        <label class="custom-file-label" for="upload-file-input">Choose file</label>
                    </div>
                </div>
                <div class="form-group" id="file-detail-group" hidden>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="display-name">Name</label>
                            <input type="text" class="form-control" name="name" id="display-name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="file-name">File Name</label>
                            <input type="text" class="form-control" name="filename" id="file-name" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <p class="form-text" id="file-size-text"></p>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>

            </form>


        </div>
    </div>
</div>

<script src="js/upload.js"></script>
