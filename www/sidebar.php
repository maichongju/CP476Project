<?php
?>

<div class="col-sm-3 col-md-2 col-lg-2 list-group text-center mt-3">
    <a href="course.php" class="list-group-item list-group-item-action">Course</a>
    <?php if ($_SESSION["userrole"] == 0 || $_SESSION["userrole"] == 1) { ?>

        <a href="#" class="list-group-item list-group-item-action">
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Coming soon">
        Manage
            </span>
        </a>

    <?php } ?>
</div>
