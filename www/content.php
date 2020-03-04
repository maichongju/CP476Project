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
<?php require_once "sidebar.php" ?>
<div class="main-content">
    <div class="preview-contianer">
        <header preview-title>
            Title of the page
        </header>
        <div class="preview">
            <iframe src="testing_pdf.pdf" type=”application/pdf” width=”100%” height=”100%”>
        </div>
        <button>download</button>
    </div>


</div>
</body>
</html>