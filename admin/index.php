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
    <!--JS-->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <!--FONT AWESOME-->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free-5.15.1-web/css/all.css">
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free-5.15.1-web/css/all.css">
</head>

<style>
.card {
    transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
    cursor: pointer;
}

.card:hover {
    transform: scale(1.05);
}
</style>

<body class="color-back">
    <div class="d-flex" id="wrapper">
        <!-- Awal Sidebar -->
        <div class="bg-dark border-right border-dark" id="sidebar-wrapper">
            <div class="sidebar-heading our-font text-center"><i class="fas fa-user-cog mr-2 "></i>Dashboard
                Admin
            </div>
            <div class="list-group list-group-flush" style="font-size:13pt;">
                <?php 
                echo "<a class='list-group-item list-group-item-action bg-dark our-font' href='user.php'><i class='fas fa-user-circle mr-2'></i>".ucfirst($user)."</a>";
                ?>
                <a href="film.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-film mr-2"></i>Film</a>
                <a href="studio.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-warehouse mr-2"></i>Studio</a>
                <a href="jadwal.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-calendar-alt mr-2"></i></i>Jadwal</a>
                <?php if($_SESSION['role'] == 1){ 
                    echo "<a href='operator_admin.php' class='list-group-item list-group-item-action bg-dark our-font'><i class='fas fa-users mr-2'></i class>Operator</a>";
                    } 
                ?>
                <a class="list-group-item list-group-item-action bg-dark our-font" href="logout_admin.php"><i
                        class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </div>
        </div>
        <!-- Akhir Sidebar -->

        <!-- Bagian Tengah -->
        <div id="page-content-wrapper">
            <!-- Awal Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top shadow-sm">
                <button class="btn color-obj" id="menu-toggle"><i class="fas fa-bars text-white"></i></button>

                <ul class="navbar-nav tengah" style="font-size:13pt;">
                    <div class="navbar-text">
                        <img src="../img/Our_Cinema_XXI.png" width="280" height="35" alt="logo cinemax">
                    </div>
                </ul>

            </nav>
            <!-- Akhir Navbar -->

            <div class="container-fluid text-white">
                <div class="row mt-5">
                    <div class="col-md-8 tengah">
                        <div class="alert alert-success" role="alert">
                            <hr class="mt-2">
                            <h4 class="alert-heading">Selamat Datang, <?php echo $_SESSION['username'] ?></h4>
                            <p>Jangan Lupa untuk Selalu mengganti password secara berkala
                            </p>
                            <hr>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bagian Tengah -->
    </div>
</body>



<!--AWAL SCRIPT-->
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
<!--AKHIR SCRIPT-->

</html>