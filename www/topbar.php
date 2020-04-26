<?php
?>

<div class="bg-light w-100">
    <div class="row mt-2">
        <div class="col-md-2">
            <a href="course.php"><img class="img-fluid" src="images/logo.png" alt=""></a>
        </div>
        <div class="col-md-4">
            <h3>
            <?php
            if (isset($course)&& !isset($course["error"])){
                echo strtoupper($course["id"]) . " - " . $course["name"];
            }else if (isset($_SESSION["courseid"]) && isset($_SESSION["coursename"])){
                echo strtoupper($_SESSION["courseid"]) . " - " . $_SESSION["coursename"];
            }
            ?>
            </h3>
        </div>
        <div class="col-md-6 ">
            <ul class="nav-item dropdown float-right mr-3">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false" href=""><?php echo $_SESSION["username"] ?></php></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="setting.php">Setting</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Log Out</a>
                </div>
            </ul>
        </div>
    </div>
</div>
