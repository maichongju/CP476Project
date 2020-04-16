<?php
// This is a page that will logout the account
session_start();
$_SESSION = null;
session_destroy();
header("location: index.php");