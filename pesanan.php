<?php
require_once "connect.php";
session_start();
require_once "security_check.php";

$id_user = $_SESSION["id_user"];
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OUR CINEMA21 [PESANAN]</title>
    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS AND OUR CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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

    <div class="container mb-5" style="margin-top: 120px;">
        <div class="row tengah">
            <div class="col-md-6 card-color-setting our-border text-black p-4 tengah">
                <div class="color-obj our-border shadow mb-3">
                    <h4 class="text-center p-2 font-weight-bold">Pesanan</h4>
                </div>
                <div id="display_pesanan"></div>
            </div>
        </div>

        <!-- Modal Detail-->
        <div class="modal fade" id="modaldetail" tabindex=" -1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body border-0">
                        <div class="row ">
                            <div class="text-center tengah">
                                <p class="text-white text-center" style="font-size:10pt;">SCAN QRCODE UNTUK MENCETAK
                                    TIKET
                                </p>
                                <div id="qrcode"></div>
                            </div>
                        </div>
                        <p id="uuid_placeholder" class="text-white text-center" style="font-size:10pt;"></p>
                        <div id="detail_tiket"></div>
                        <span class="text-white" style="font-size:15pt;"> Kursi : </span>
                        <div id="kursi_pesan"></div>
                        <div id="btn-batal" class="text-center"></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal alert batal-->
        <div class="modal fade" id="alert_batal" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content color-back">
                    <div class="modal-body">
                        <div class="text-center ">
                            <i class="fas fa-exclamation-circle text-danger" style="font-size:100pt;"></i>
                            <p class="text-white text-center mt-4">Yakin ingin membatalkan Tiket ?</p>
                            <button class="btn btn-success" id="iya_batal">Iya, Batalkan</button>
                            <button class="btn btn-danger" id="tidak_jadi">Tidak Jadi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal alert batal -->

        <!-- Modal -->
        <div class="modal fade" id="proses_batal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content  bg-dark">
                    <div class="modal-body border-0">
                        <div id="proses">
                            <div class="loader tengah"></div>
                            <p class="text-white text-center mt-4">Membatalkan Tiket</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END OFF DIV CONTAINER -->
</body>

<script>
var qrdata = document.getElementById('qr-data');
var qrcode = new QRCode(document.getElementById('qrcode'));

function generateQR(uid) {
    qrcode.makeCode(uid);
}
$(document).ready(function() {


    function load_data() {
        $.ajax({
            type: "GET",
            url: 'process/get_all_pesanan.php?id_user=<?php echo $_SESSION['id_user']?>',
            success: function(response) {
                try {
                    response = $.parseJSON(response);
                    console.log(response)
                    response.forEach(function(data) {
                        console.log(data['jam_pesan'])
                        // <img class='our-card-show-fil' src='" +data['poster'] +"' alt='" +data['judul_film'] +"'>
                        var txt2 =
                            "<div class='card mb-3 border-0 hoper-animation our-card-show-pesanan' style='width:auto;' id='" +
                            data['id_pesanan'] +
                            "'><div class='card-body'><h4 class='card-title mb-4'>" +
                            data['judul_film'] +
                            "</h4><h1 class='float-right'><i class='fas fa-ellipsis-v text-black'></i></h1><h5 class='card-subtitle mb-2 text-muted'><i class='fas fa-calendar-alt'></i> " +
                            data['tanggal_tayang'] + "<br><i class='fas fa-clock'></i> " +
                            data['jam_tayang']
                        "</h5></div></div>";
                        $("#display_pesanan").append(txt2)
                    })
                } catch (e) {}
            },
            error: function() {
                window.location.replace("error_page.php")
            }
        });
    }

    load_data();

    $(document).on("click", ".card", function() {
        $idd = $(this).attr('id');
        var kursi = []
        $("#detail_tiket").empty();
        $("#uuid_placeholder").empty();
        $("#btn-batal").empty();
        $("#kursi_pesan").empty();

        $.ajax({
            type: "GET",
            url: 'process/get_pesanan_kursi.php?id_pesanan=' + $idd,
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
        $.ajax({
            type: "GET",
            url: 'process/get_data_tiket.php?id_pesanan=' + $idd,
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
                    if (Number(response.jarak_tanggal) > 1) { //setting waktu
                        var txt3 =
                            "<a class='btn btn-danger mt-5' id='batal_tiket'>Batalkan Tiket</a>"
                    } else {
                        var txt3 =
                            "<button class='btn btn-danger mt-5' id='batal_tiket' disabled>Batalkan Tiket</button>"
                    }
                    $("#detail_tiket").append(txt1);
                    $("#uuid_placeholder").html(response.uuid);
                    $("#btn-batal").append(txt3);

                } catch (e) {}
            },
            error: function() {
                window.location.replace("error_page.php")
            }
        });

        $("#modaldetail").modal("show");
    });
    $(document).on("click", "#batal_tiket", function() {
        $("#alert_batal").modal("show");
    });
    $(document).on("click", "#tidak_jadi", function() {
        $("#alert_batal").modal("hide");
    });
    $(document).on("click", "#iya_batal", function() {
        $.ajax({
            type: "GET",
            url: 'process/batal_tiket.php?id_pesanan=' + $idd,
            success: function(response) {
                $("#alert_batal").modal('hide');
                $("#proses_batal").modal('show');
                $("#sukses").hide();
                setTimeout(proses, 3000);
            },
            error: function() {
                window.location.replace("error_page.php")
            }
        });

    });

    function proses() {
        $("#proses").hide();
        $("#proses_batal").modal('hide');
        $("#alert_batal").modal("hide");
        $("#modaldetail").modal("hide");
        window.location.replace("pesanan.php")
    }

});
</script>

</html>