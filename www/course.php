<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <link href="css/project.css" rel="stylesheet">
</head>
<body>
<?php require_once "topbar.php" ?>
<div>
    <?php require_once "sidebar.php" ?>
    <div class="main-content">
        <div class="items">
            <header class="file-title">assignment1</header>
            <img class="file-icon" src="images/icon-word.png">
            <div class="file-but-containor">
                <button class="file-but">Preview</button>
                <button class="file-but">Comment</button>
                <button class="file-but">Download</button>
            </div>

        </div>
        <div class="items">
            <header class="file-title">assignment2</header>
            <img class="file-icon" src="images/icon-word.png">
            <div class="file-but-containor">
                <button class="file-but">Preview</button>
                <button class="file-but">Comment</button>
                <button class="file-but">Download</button>
            </div>

        </div>
        <div class="items">
            <header class="file-title">lecture1</header>
            <img class="file-icon" src="images/icon-word.png">
            <div class="file-but-containor">
                <button class="file-but">Preview</button>
                <button class="file-but">Comment</button>
                <button class="file-but">Download</button>
            </div>

        </div>

    </div>

</div>
</div>


</body>