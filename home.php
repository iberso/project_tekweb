<?php
require_once "connect.php";
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user = $_SESSION["username"];
}else {
    $user = "";
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OUR CINEMA21 [HOME]</title>
    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS AND OUR CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/our-cinema-style.css">
    <!--JS-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <!--FONT AWESOME-->
    <link rel="stylesheet" type="text/css" href="fontawesome-free-5.15.1-web/css/all.css">
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="fontawesome-free-5.15.1-web/css/all.css">
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
    <!--AWAL NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <img src="img/Our_Cinema_XXI.png" width="300" height="40" alt="logo cinemax">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto" style="font-size:13pt;">
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#"><i class='fas fa-user-circle mr-1'></i> -->
                        <?php 
                        if($user == ""){
                            echo "<a class='nav-link' href='login.php'><i class='fas fa-user-circle mr-1'></i>Akun</a>";
                        }else{
                            echo "<a class='nav-link' href='akun.php'><i class='fas fa-user-circle mr-1'></i>".ucfirst($user)."</a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="fas fa-home mr-1"></i>Beranda</a>
                    </li>
                    <li class="nav-item">
                        <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        echo "<a class='nav-link' href='pesanan.php'><i class='fas fa-shopping-cart mr-1'></i>Pesanan</a>";
                    }else {
                        echo "<a class='nav-link' data-toggle='modal' data-target='#req_login'><i
                        class='fas fa-shopping-cart mr-1'></i>Pesanan</a>";
                    }?>
                        <!-- <a class="nav-link" href="pesanan.php"><i class="fas fa-shopping-cart mr-1"></i>Pesanan</a> -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->
    <!-- Modal REQ LOGIN -->
    <div class="modal fade" id="req_login" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content color-back">
                <div class="modal-body">
                    <div class="text-center ">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size:100pt;"></i>
                        <p class="text-white text-center mt-4">Harap Login Terlebih Dahulu!!</p>
                        <a class=" btn color-obj font-weight-bold" href="login.php">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal REQ LOGIN -->
    <div class="container" style="margin-top: 150px;">
        <div class="row">
            <div class="col-sm-3 my-1 mb-4">
                <div class="input-group ">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-secondary text-white border-0"><i
                                class="fas fa-search color-font"></i>
                        </div>
                    </div>
                    <input type="text" id="search_film" autocomplete="off"
                        class="form-control bg-dark border-0 text-white" placeholder="Cari Film...">
                </div>
                <ul id="hsl_search"></ul>

            </div>
        </div>
        <div class="row" id="list_film">
        </div>
        <!--END OFF DIV ROW-->
    </div>
    <!--END OFF DIV CONTAINER -->
</body>


<!--AWAL SCRIPT-->
<script>
$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: 'process/get_film_list.php',
        success: function(response) {
            try {
                response = $.parseJSON(response);
                response.forEach(function(data) {
                    console.log(data['judul_film'])
                    var txt1 = "<div class='col-lg-3 col-6 mb-5 text-black' id='" +
                        data['id_film'] +
                        "' > <div class='card shadow-sm card-our-setting bg-secondary border-0' style='width:100%'><img class='card-img-top' src='" +
                        data['poster'] +
                        "' alt='Card image cap'> <div class='card-body color-obj'><h5 class='card-title text-center'>" +
                        data['judul_film'] + "</h5></div></div></div>"
                    $("#list_film").append(txt1)
                })
            } catch (e) {
                window.location.replace("error_page.php")
            }
        },
        error: function() {
            window.location.replace("error_page.php")
        }
    });

    $(document).on("click", ".card", function() {
        $idd = $(this).parent().attr('id');
        window.location.href = "show_film.php?id=" + $idd;
    });
    $("#search_film").keyup(function() {
        var search = $(this).val();
        $q = search;
        if (search != "") {
            $.ajax({
                type: "GET",
                url: 'process/search_film.php?q=' + $q,
                success: function(response) {
                    try {
                        response = $.parseJSON(response);
                        console.log("judul = " + response);
                        $("#hsl_search").empty();
                        response.forEach(function(data) {
                            $("#hsl_search").append(
                                "<li class='text-white' value='" +
                                data[
                                    'id_film'] + "'>" +
                                data['judul_film'] + "</li>");
                        })
                        $("#hsl_search li").bind("click", function() {
                            window.location.href = "show_film.php?id=" + $(this)
                                .val();
                        });
                    } catch (e) {
                        window.location.replace("error_page.php")
                    }
                },
                error: function() {
                    window.location.replace("error_page.php")
                }
            });
        } else {
            $("#hsl_search").empty();
        }
    });

});
</script>
<!--AKHIR SCRIPT-->

</html>