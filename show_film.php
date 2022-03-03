<?php

require_once "connect.php";
session_start();

if($_GET['id'] == ""){//buat pengecekan jika ada orang berusaha direct ke halaman ini
    header("location:home.php");
    exit;
}

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
    <title>OUR CINEMA21 [FILM]</title>
    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS AND OUR CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/our-cinema-style.css">
    <!--FONT AWESOME-->
    <link rel="stylesheet" type="text/css" href="fontawesome-free-5.15.1-web/css/all.css">
</head>

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
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->

    <!--INI MODALS UNTUK PILIH KURSI-->
    <div class="container-fluid">
        <div class="modal fade" id="modal_kursi" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content color-back">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="staticBackdropLabel">Pesan Tiket</h5>
                        <button type="button" id="close_modal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <h5 class="text-white">Hari / Tanggal</h5>
                                    <select class="custom-select bg-dark border-0 text-white" id="tanggal_tayang">
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div id="harga" class="text-white"></div>
                                <div class="form-group col-md-6 mt-3" id="nm_studio_placeholder">
                                    <!-- <h5>STUDIO 1</h5> -->
                                    <div id="jam_placeholder">

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="container-fluid" id="detail-pesan">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p class="text-white">Legend Kursi</p>
                                    <h5>
                                        <p class="badge bg-danger btn-sm text-white p-2">Terisi</p>
                                        <p class="badge text-white color-black border-top text-white p-2">Kosong</p>
                                        <p class="badge color-obj btn-sm text-white p-2">Dipilih</p>
                                    </h5>
                                </div>
                            </div>
                            <div class="row table-kursi">
                                <div class="col-md-12 p-3 tengah rounded color-back-tbl shadow-sm">
                                    <div id="layar"
                                        class="border rounded border-dark bg-dark font-weight-bold text-center text-white tengah mb-3">
                                        LAYAR
                                    </div>
                                    <div class="table-responsive-lg">
                                        <table id="isi_kursi" class="tabel-kursi tengah">

                                        </table>
                                    </div>
                                </div>
                            </div>


                            <h5 class="color-font mt-4"> Detail Tiket</h5>
                            <div class="row">
                                <div class="col-md-5 tengah">

                                    <span class="text-white"> Judul : </span>
                                    <span class="text-white" id="judul-film"></span></br>

                                    <span class="text-white"> Tanggal : </span>
                                    <span class="text-white" id="tanggal-film"></span></br>

                                    <span class="text-white"> Jam : </span>
                                    <span class="text-white" id="jam-film"></span></br>
                                    <span class="text-white"> Harga : </span>
                                    <!-- <span class="text-white" id="harga_fil"></span></br> -->

                                    <span class="text-white" id="harga_fil" data-a-sign="Rp. " data-a-dec=","
                                        data-a-sep="."></span></br>
                                </div>
                                <div class="col-md-5 tengah">
                                    <span class="text-white"> Jumlah Kursi : </span>
                                    <span class="text-white" id="jumlah-kursi">0</span></br>

                                    <span class="text-white"> No Kursi : </span>
                                    <span class="text-white" id="no-kursi"></span></br>

                                    <span class="text-white"> Total Harga: </span>
                                    <span class="text-white" id="total-harga"></span>
                                </div>
                                <div class="col-md-2">
                                    <button type=" button" id="pesan_tiket"
                                        class="btn btn-success btn-block btn text-white font-weight-bold mt-2">Pesan
                                        Tiket</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--INI AKHIR MODALS UNTUK PILIH KURSI-->

    <!-- Modal proses -->
    <div class="modal fade" id="proses" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content color-back">
                <div class="modal-body">
                    <div class="loader tengah"></div>
                    <p class="text-white text-center mt-4">Memproses Tiket</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal proses -->

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

    <!-- Modal alert kursi-->
    <div class="modal fade" id="alert_kursi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content color-back">
                <div class="modal-body">
                    <div class="text-center ">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size:100pt;"></i>
                        <p class="text-white text-center mt-4">1 Pesanan Maksimal 10 kursi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal alert kursi -->

    <!-- Modal alert pilih kursi-->
    <div class="modal fade" id="alert_pilih_kursi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content color-back">
                <div class="modal-body">
                    <div class="text-center ">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size:100pt;"></i>
                        <p class="text-white text-center mt-4">Anda harus memilih kursi</p>
                    </div>
                    <button type="button" id="close_modal" class="btn btn-success btn-block" data-dismiss="modal"
                        aria-label="Close">
                        OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal alert pilih kursi -->
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-lg-3 col-sm-12 mb-4 ">
                <div class="card shadow border-0 card-our-setting" style="width: 16rem">
                    <div id="poster-placeholder">
                    </div>
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        echo "<button id='pesan_btn' class='btn color-obj font-style text-black btn-block' data-toggle='modal'
                        data-target='#modal_kursi'>";
                        echo "<h4>PESAN</h4></button>";
                    }else {
                        echo "<button id='pesan_login' class='btn color-obj font-style text-black btn-block' data-toggle='modal'
                        data-target='#req_login'>";
                        echo "<h4>PESAN</h4></button>";
                    }?>
                </div>
            </div>

            <div class="col-lg-9 col-sm-12">
                <!-- START OF CARD -->
                <div class="card text-white card-color-setting">
                    <div class="card-body shadow" id="content">
                    </div>
                </div>
                <!-- END OF CARD -->
            </div>
            <!--END OFF DIV ROW-->
        </div>
        <!--END OFF DIV CONTAINER -->
    </div>
</body>

<!--JQUERY-->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--JS-->
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/autoNumeric/autoNumeric.js"></script>
<!--AWAL SCRIPT-->
<script type="text/javascript" src="js/our_cinema_scripts/script_our_cinema.js"></script>
<!--Format Currency-->
<!--AKHIR SCRIPT-->

</html>