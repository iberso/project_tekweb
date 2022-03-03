<?php
require_once "connect.php";
session_start();
require_once "security_check.php";

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OUR CINEMA21 [PEMBAYARAN]</title>
    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS AND OUR CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/our-cinema-style.css">
    <!--JQUERY-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--JS-->
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <!-- <script type="text/javascript" src="js/qrcode/qrcode.min.js"></script> -->
    <script type="text/javascript" src="js/qrcode/qrcode.js"></script>

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
                        <a class="nav-link" href="pesanan.php"><i class="fas fa-shopping-cart mr-1"></i>Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content  our-alert-proses ">
                <div class="modal-body border-0">
                    <div id="proses">
                        <div class="loader tengah"></div>
                        <p class="text-white text-center mt-4">Memproses Pembayaran</p>
                    </div>
                    <div id="sukses">
                        <p class="text-center"><i class="fas fa-check-circle text-success" style="font-size:100pt;"></i>
                        </p>
                        <p class="text-white text-center mt-4">Pembayaran Sukses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Modal Detail-->
        <div class="modal fade" id="modaldetail" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content  our-alert-proses ">
                    <div class="modal-body border-0">
                        <div class="text-center">
                            <p class="text-white text-center" style="font-size:10pt;">SCAN QRCODE UNTUK MENCETAK TIKET
                            </p>
                            <div id="qrcode"></div>
                        </div>
                    </div>
                    <p id="uuid_placeholder" class="text-white text-center" style="font-size:10pt;"></p>
                    <div id="detail_tiket"></div>
                    <span class="text-white" style="font-size:15pt;"> Kursi : </span>
                    <div id="kursi_pesan"></div>
                    <a class="btn btn-danger mt-2 mb-2" href="home.php">Menu Utama</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12" id="bagian_atas">
                <div class="card text-white">
                    <div class="card-body">
                        <h1 class="color-font font-weight-bold">Pembayaran</h1>
                        <h5 class="card-title mt-4">Silahkan pilih metode pembayaran</h5>
                        <button type="button" class="btn btn-light rounded hoper-animation p-2 mr-2 mb-2"><img
                                src="img/pembayaran/gopay.png" width="110" height="25"></button>
                        <button class="btn btn-light btn-light rounded hoper-animation p-2 mr-2 mb-2"><img
                                src="img/pembayaran/ovo.png" width="110" height="25"></button>
                        <button class="btn btn-light btn-light rounded hoper-animation p-2 mr-2 mb-2"><img
                                src="img/pembayaran/bca.png" width="110" height="25"></button>
                        <button class="btn btn-light btn-light  rounded hoper-animation p-2 mr-2 mb-2"><img
                                src="img/pembayaran/mandiri.png" width="110" height="25"></button>
                        <br> <!-- Button trigger modal -->
                        <button type="button" id="btn_bayar" class="btn color-obj font-weight-bold mt-4"
                            data-toggle="modal" data-target="#exampleModalCenter">
                            Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
var qrdata = document.getElementById('qr-data');
var qrcode = new QRCode(document.getElementById('qrcode'));

function generateQR(uid) {
    qrcode.makeCode(uid);
}

$(document).ready(function() {
    $("#bagian_bawah").hide();
    $("#bagian_bawah2").hide();

    $("#btn_bayar").on("click", function() {
        $("#sukses").hide();
        setTimeout(proses, 3000);
    });

    function proses() {
        $("#proses").hide();
        $("#sukses").show();
        setTimeout(munculin_content, 2000);
    };
    var kursi = [];
    $.ajax({
        type: "GET",
        url: 'process/get_pesanan_kursi.php?id_pesanan=<?php echo $_SESSION['id_pesanan']?>',
        success: function(response) {
            response = $.parseJSON(response);
            response.forEach(function(data) {
                var x = data['pos_x'];
                var y = data['pos_y'] + 1;
                var pil_X = String.fromCharCode(x + 65);
                var pil_Y = String(y);
                // console.log(data['pos_y']);
                // console.log(pil_X + "," + pil_Y)
                kursi.push(pil_X + pil_Y + " ");

            })
            var kur_pesan = "<h4 class='color-font'>" + kursi + "</h4>"
            $("#kursi_pesan").append(kur_pesan);
        },
        error: function() {
            window.location.replace("error_page.php")
        }
    });

    function munculin_content() {
        $("#bagian_atas").hide();
        $('#exampleModalCenter').modal('hide');
        $('#modaldetail').modal('show');


        $.ajax({
            type: "GET",
            url: 'process/get_data_tiket.php',
            success: function(response) {
                try {
                    response = $.parseJSON(response);
                    // console.log(response.judul_film); // or whatever you want do with that
                    console.log(response);
                    generateQR(response.uuid)
                    var txt1 =
                        "<h3 class ='color-font text-center mb-3'>" + response.nama_studio +
                        " </h3><span class ='text-white' style = 'font-size:15pt;'> Judul : </span><h4 class ='color-font'>" +
                        response.judul_film +
                        " </h4> <span class ='text-white' style = 'font-size:15pt;'> Tanggal Tayang : </span><h4 class ='color-font'>" +
                        response.tanggal_tayang +
                        " </h4><span class ='text-white' style = 'font-size:15pt;'> Jam Tayang : </span><h4 class ='color-font'>" +
                        response.jam_tayang +
                        " </h4>"
                    $("#detail_tiket").append(txt1);
                    $("#uuid_placeholder").html(response.uuid);
                } catch (e) {
                    window.location.replace("error_page.php")
                }
            },
            error: function() {
                window.location.replace("error_page.php")
            }
        });
    };
});
</script>

</html>