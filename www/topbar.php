<?php
?>

<div class="bg-light w-100">
    <div class="row">
        <div class="col-md-4">
            <h1>Title</h1>
        </div>
        <div class="col-md-8 ">
            <ul class="nav-item dropdown float-right mr-3">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                   aria-expanded="false" href=""><?php echo $_SESSION["username"] ?></php></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="logout.php">logout</a>
                </div>
            </ul>
        </div>
    </div>
</div>
