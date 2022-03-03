<?php
include "security_check_admin.php";
include "../connect.php";
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OUR CINEMA21 [ADMIN DASHBOARD]</title>
    <link rel="icon" href="../img/XXI.ico">

    <!--BOOTSTRAPS-->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/our-cinema-style.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_css.css">
    <!--FONT AWESOME-->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free-5.15.1-web/css/all.css">
    <!--JS-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="../img/XXI.ico">
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<style>
.tengah {
    margin-left: auto;
    margin-right: auto;
}

.nav-col {
    background-color: #16697a;
}
</style>

<body class="color-back">

    <!--AWAL NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top shadow-sm">
        <div class="container">
            <a class="navbar-brand tengah" href="home.php">
                <img src="../img/Our_Cinema_XXI.png" width="300" height="40" alt="logo cinemax">
            </a>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->

    <div class="container" style="margin-top:200px;">
        <div class="row text-white">
            <div class="col-md-12 text-center">
                <i class="fas fa-exclamation-triangle fa-7x text-danger"></i>
                <h1 class="display-4 text-center">ERROR, Something Wrong</h1>
                <a href="index.php" class="btn btn-success mt-5">Back To Home</a>
            </div>
        </div>

    </div>

</body>

</html>