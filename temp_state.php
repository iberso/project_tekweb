<?php
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
include "connect.php";
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS AND OUR CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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

<!--AWAL SCRIPT-->
<script>
$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: 'process/get_film_list.php?id=<?php echo $_GET['id'] ?>',
        success: function(response) {
            try {
                response = $.parseJSON(response);
                // console.log(response.judul_film); // or whatever you want do with that
                var txt1 =
                    "<div class='float-right d-inline border border-success rounded color-obj p-1 font-weight-bold'>" +
                    response.durasi + " menit</div><h2 class='card-title color-font mb-4'>" +
                    response
                    .judul_film +
                    "</h2> <p>Jenis Film : " + response.genre + "</p><p> Sutradara : " + response
                    .sutradara + "</p><p> Produksi : " + response.produksi +
                    "</p><h5><span class='badge badge-danger'>" + response.kategori_umur +
                    "</span></h5><br><h4 class ='card-title color-font mb-4'> Sinopsi </h4><p class = 'text-white' >" +
                    response.sinopsi + "</p> "

                var txt2 = "<img class='card-img-top' src='" + response.poster +
                    "'alt='Card image cap'>"
                $("#content").append(txt1)
                $("#poster-placeholder").append(txt2)
                $("#judul-film").html(response.judul_film)
            } catch (e) {}
        },
        error: function() {
            window.location.replace("home.php")
        }
    });
    $("#pesan_btn").on("click", function() {
        $.ajax({
            type: "GET",
            url: 'process/get_tanggal_tayang.php?id=<?php echo $_GET['id'] ?>',
            success: function(response) {
                try {
                    response = $.parseJSON(response);
                    $("#tanggal_tayang").append(
                        "<option selected hidden class='text-muted'></option>"
                    );
                    response.forEach(function(data) {
                        var txt1 = "<option value=" +
                            data['tanggal_val'] +
                            ">" + data['tanggal_tayang'] +
                            "</option>"
                        // console.log(txt1);
                        $("#tanggal_tayang").append(txt1)

                    })
                } catch (e) {}
            },
            error: function() {
                window.location.replace("home.php")
            }
        });
    });

    $("#detail-pesan").hide();

    $("#close_modal").on("click", function() {
        $("#tanggal_tayang").empty();
        $("#jam_placeholder").empty();
        $("#layar").hide();
        $("#detail-pesan").hide();
        clean_detail();
    });

    function clean_detail() {
        $("#no-kursi").empty();
        $("#tanggal-film").empty();
        $("#jam-film").empty();
        $("#jumlah-kursi").html(0);
    }

    var tgl, id_std, jm_t;
    $("#tanggal_tayang").change(function() {
        $("#jam_placeholder").empty();
        $("#isi_kursi").empty();
        $("#layar").hide();
        clean_detail();
        // $("#jumlah-kursi").html(0);
        // $("#no-kursi").empty();
        // $("#tanggal-film").empty();
        // $("#jam-film").empty();

        tgl = $(this).val();

        $.ajax({
            type: "GET",
            url: 'process/get_nama_studio.php?id=<?php echo $_GET['id'] ?>&tgl_t=' + tgl,
            success: function(response) {
                try {
                    response = $.parseJSON(response);
                    // console.log("nama_studio : " + response[i].nama_studio)

                    response.forEach(function(datat) {
                        //console.log("nama_studio dan id = " + datat['nama_studio'] +" " + datat['id_studio'])
                        var nm_std =
                            "<h5 class='mt-2 text-capitalize text-white'>" + datat[
                                'nama_studio'] +
                            "</h5>"
                        // console.log(txt1);
                        id_std = datat['id_studio']

                        //batas atas ajax jam
                        $.ajax({
                            type: "GET",
                            url: 'process/get_jam_tayang.php?id=<?php echo $_GET['id'] ?>&tgl_t=' +
                                tgl + '&id_std=' + id_std,
                            success: function(responsee) {
                                try {
                                    responsee = $.parseJSON(
                                        responsee);
                                    // console.log("nama_studio : " + response[i].nama_studio)
                                    $("#jam_placeholder").append(
                                        nm_std)
                                    responsee.forEach(function(data) {
                                        var txt2 =
                                            "<div id='jam" +
                                            datat['id_studio'] +
                                            "' class='btn mr-2 jm color-unpick text-white hoper-animation' >" +
                                            data['jam_val'] +
                                            "</div>"
                                        console.log(txt2);
                                        $("#jam_placeholder")
                                            .append(txt2)

                                    })
                                } catch (e) {}
                            },
                            error: function() {
                                window.location.replace("home.php")
                            }
                        });
                        //batas bawah ajax jam
                    })
                } catch (e) {}
            },
            error: function() {
                window.location.replace("home.php")
            }
        });
    });


    $("#layar").hide();
    //buat milih jam
    $(document).on("click", ".jm", function() {
        var pos_X = []
        var pos_Y = []
        $("#isi_kursi").empty();
        $("#layar").show();
        $("#detail-pesan").show();
        $("#jumlah-kursi").html(0);
        $("#no-kursi").empty();

        $("#jam_placeholder .btn").each(function() {
            //alert("JAM = " + $(this).html());
            if ($(this).hasClass("color-obj")) {
                $(this).removeClass("color-obj")
            }
        });
        $(this).addClass("color-obj");

        $("#jam-film").html($(this).text())
        $("#tanggal-film").html($("#tanggal_tayang").children("option:selected").text())

        jm_t = $(this).text();
        td = ($(this).attr("id")).substr(3, 3); // biar cuman ambil id_studio

        //alert("tanggal = " + tgl + " id_studio = " + td + " jam_tayang = " + jm_t)

        $.ajax({
            type: "GET",
            url: 'process/get_kursi_studio.php?id=<?php echo $_GET['id'] ?>&tgl_t=' + tgl +
                '&id_std=' + td + '&jm_t=' + jm_t,
            success: function(responses) {
                try {
                    responses = $.parseJSON(responses);
                    responses.forEach(function(dat) {
                        pos_X.push(dat['pos_x'])
                        pos_Y.push(dat['pos_y'])
                    })

                    //GENERATE TABLE KURSI
                    for (var i = 0; i < 12; i++) {
                        var tbl;
                        tbl = "<tr>";
                        for (var j = 0; j < 16; j++) {
                            tbl +=
                                "<td><button type='button' id='pos_kursi' class='btn btn-sm text-white our-kursi color-black hoper-animation'>" +
                                String.fromCharCode(65 + i) + (j + 1) +
                                "</button></td>";
                        }
                        tbl += "</tr>";
                        $("#isi_kursi").append(tbl)
                    }
                    //GENERATE

                    //isi kursi 
                    for (var i = 0; i < pos_X.length; i++) {
                        // $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(pos_Y[i]).html("X")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(
                                pos_Y[i])
                            .find("button").removeClass("color-black")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(
                                pos_Y[i])
                            .find("button").removeClass("border-top")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(
                                pos_Y[i])
                            .find("button").addClass("btn-danger")
                        $("#isi_kursi").find("tr").eq(pos_X[i]).find("td").eq(
                                pos_Y[i])
                            .find("button").attr("disabled", true)
                        console.log()
                    }
                    //isi kursi 
                } catch (e) {}
            },
            error: function() {
                window.location.replace("home.php")
            }
        });
    });

    $(document).on("click", "#pos_kursi", function() {

        // console.log($(this).html())
        // console.log("X = " + ($(this).html().charCodeAt(0) - 65) + " Y = " + ($(this).text().substr(1,2) - 1)) 
        var jml_kursi = 0;
        var pil_X = ($(this).html().charCodeAt(0) - 65);
        var pil_Y = ($(this).text().substr(1, 2) - 1);

        $("#isi_kursi  > tr > td .btn").each(function() {
            if ($(this).hasClass("color-obj")) {
                jml_kursi += 1;
            }
        });

        if (jml_kursi != 10 || $("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button")
            .hasClass("color-obj")) {
            if ($("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button").hasClass(
                    "color-obj")) {
                $("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button").toggleClass(
                    "color-obj color-black")
            } else {
                $("#isi_kursi").find("tr").eq(pil_X).find("td").eq(pil_Y).find("button").toggleClass(
                    "color-obj color-black")
            }

            $("#no-kursi").empty();

            jml_kursi = 0; //untuk reset kembali counter kursi

            $("#isi_kursi  > tr > td .btn").each(function() {
                if ($(this).hasClass("color-obj")) {
                    console.log($(this).html());
                    jml_kursi += 1;
                    if (jml_kursi > 1) {
                        $("#no-kursi").append(", " + $(this).html());
                    } else {
                        $("#no-kursi").append($(this).html());
                    }
                }
            });

            $("#jumlah-kursi").html(jml_kursi);
        } else {
            alert("1 Pesanan Maksimal 10 Kursi");
            return;
        }
    });
});
</script>


<body class="color-back">

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
                                <div class="form-group col-md-6 mt-3" id="nm_studio_placeholder">
                                    <!-- <h5>STUDIO 1</h5> -->
                                    <div id="jam_placeholder">

                                    </div>

                                </div>
                            </div>
                            <!-- <h5 class="text-muted">Harga</h5>
                            <input type="text" id="ehrg" name="ehrg" class="form-control" data-a-sign="Rp. "
                                data-a-dec="," data-a-sep="." placeholder="Harga">
                            </br> -->
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

                                </div>
                                <div class="col-md-5 tengah">
                                    <span class="text-white"> Jumlah Kursi : </span>
                                    <span class="text-white" id="jumlah-kursi">0</span></br>

                                    <span class="text-white"> No Kursi : </span>
                                    <span class="text-white" id="no-kursi"></span>
                                </div>
                                <div class="col-md-2">
                                    <button type=" button" id="pesan_tiket"
                                        class="btn btn-success btn-block btntext-white font-weight-bold mt-2">Pesan
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

    <!-- Just an image -->
    <nav class="navbar color-primary">
        <a class="navbar-brand" href="home.php">
            <img src="img/Our_Cinema_XXI.png" width="300" height="40" alt="logo cinemax" loading="lazy">
        </a>
        <span class="navbar-text">
            <?php
            if($user == ""){
                echo "<a href='login.php'>Login</a>";
            }else{
                echo "<span class='text-white'>Selamat Datang, ".ucfirst($user)."<i class='fas fa-user-circle'></i></span>";
            }
            ?>
        </span>
    </nav>
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-lg-3 col-sm-12 mb-4 ">
                <div class="card shadow border-0 card-our-setting" style="width: 16rem">
                    <div id="poster-placeholder">
                    </div>
                    <button id="pesan_btn" class="btn color-obj font-style text-white btn-block" data-toggle="modal"
                        data-target="#modal_kursi">
                        <h4>PESAN</h4>
                    </button>
                </div>
            </div>

            <div class="col-lg-9 col-sm-12">
                <!-- START OF CARD -->
                <div class="card text-white card-our-setting">
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

</html>