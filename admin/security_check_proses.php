<?php
session_start();
if (isset($_SESSION["loggedinadmin"]) && $_SESSION["loggedinadmin"] === true) {
    $user = $_SESSION["username"];
}else {
    $user = "";
    header("location:../login_admin.php");
    exit;
}
?>