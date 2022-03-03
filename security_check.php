<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user = $_SESSION["username"];
}else {
    $user = "";
    header("location:home.php");
    exit;
}
?>