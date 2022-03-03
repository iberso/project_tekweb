<?php
include "../connect.php";
session_start();

if (isset($_SESSION["loggedinadmin"]) && $_SESSION["loggedinadmin"] === true) {
    $user = $_SESSION["username"];
    // $_SESSION['pesanerror'] ="";
    // $_SESSION['pesansukses'] ="";
    // $_SESSION['sukses'] = 0;
}else {
    header("location:login_admin.php");
    exit;
}
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
                <a href="jadwal.php" class="list-group-item list-group-item-action bg-secondary our-font"><i
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
                <div class="row p-2 text-center mt-5 ">
                    <div class="col-md-12">
                        <a class="btn btn-info font-weight-bold mr-2" href="#" id="btn_lihat_jadwal">Lihat Jadwal</a>
                        <a class="btn btn-success font-weight-bold mr-2" href="#" id="btn_tambah_jadwal">Tambah
                            Jadwal</a>
                    </div>
                </div>
                <div class="row p-2 animate-bottom hide-div" id="tambah_jadwal">
                    <div class="col-md-6 tengah">
                        <h1 class="mt-5 text-center">Form Tambah Film</h1>

                        <form class="mt-5" id="form_isi_jadwal" method="POST" action="process/post_jadwal.php"
                            enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Tanggal Tayang</label>
                                    <input type="date" class="form-control" id="tanggal_tayang" name="tanggal_tayang">
                                    <div class="invalid-feedback">
                                        *Tanggal Tayang Tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jam Tayang</label>
                                    <input type="time" class="form-control" name="jam_tayang" id="jam_tayang">
                                    <div class="invalid-feedback">
                                        *Jam Tayang Tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="harga" id="harga" data-a-sign="Rp. "
                                        data-a-dec="," data-a-sep="." placeholder="harga">
                                    <div class="invalid-feedback">
                                        *Harga Tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Studio</label>
                                    <select class="form-control" name="studio" id="studio">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Film</label>
                                <select class="form-control" name="film" id="film">
                                </select>
                            </div>
                        </form>
                        <div class="text-center mt-5">
                            <button type="submit" id="submit_jadwal" name="submit" class="btn btn-primary">Tambah
                                Jadwal</button>
                        </div>
                    </div>
                </div>

                <!-- DATA JADWAL-->
                <div class="row p-2 animate-bottom" id="data_jadwal">
                    <div class="col-md-11 mt-3 tengah">
                        <h1 class="text-center">Data Jadwal</h1>
                        <table class="table text-white mt-5 our-table-hover table-responsive-lg" style="width:100%">
                            <div class="container mt-5">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-primary active">
                                                <input type="radio" name="options" id="radio1" autocomplete="off">Jadwal
                                                Aktif
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" id="radio2" autocomplete="off">Jadwal
                                                Non-Aktif
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" id="radio3" autocomplete="off"
                                                    checked>
                                                Semua
                                                Jadwal
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <input class="form-control" id="search_input" type="text"
                                            placeholder="cari data.."><br>
                                    </div>
                                </div>
                            </div>

                            <thead class="text-center">
                                <tr>
                                    <th>Id Jadwal</th>
                                    <th class="align-middle">Tanggal Tayang</th>
                                    <th class="align-middle">Jam Tayang</th>
                                    <th class="align-middle">Harga</th>
                                    <th class="align-middle">Studio</th>
                                    <th class="align-middle">Film</th>
                                    <th class="align-middle">Created By</th>
                                    <th class="align-middle" colspan="2">Detail</th>
                                </tr>
                            </thead>
                            <tbody id="table_jadwal">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- Bagian Tengah -->
    </div>

    <!-- Modal proses loading -->
    <div class="modal fade" id="proses_loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle fa-7x text-success"></i>
                    <h4 class="text-white mt-5">Data Berhasil Ditambahkan</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal proses error-->
    <div class="modal fade" id="proses_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-circle fa-7x text-danger"></i>
                    <h5 class="text-white mt-5"><?php if(isset($_SESSION['pesanerror'])){
                                echo $_SESSION['pesanerror'];
                            }?></h5>
                    <h5 class="text-white mt-5"><?php if(isset($_SESSION['epesanerror'])){
                                echo $_SESSION['epesanerror'];
                            }?></h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal alert hapus-->
    <div class="modal fade" id="alert_hapus" tabindex="0" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-circle fa-7x text-danger"></i>
                    <h5 class="text-white mt-3 mb-2">Apakah Anda Yakin ingin menghapus data ini ?</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal proses edit sukses -->
    <div class="modal fade" id="proses_edit_sukes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle fa-7x text-success"></i>
                    <h4 class="text-white mt-5">Data Berhasil Diedit</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal proses hapus sukses -->
    <div class="modal fade" id="proses_hapus_sukes" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle fa-7x text-success"></i>
                    <h4 class="text-white mt-5">Data Berhasil Dihapus/DiNon-Aktifkan</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL DETAIL -->
    <div class="modal fade" tabindex="-1" id="modal_detail" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Jadwal</h5>
                </div>

                <div class="modal-body" id="isi_detail">
                    <h1 id="id_jadwal"></h1>
                </div>
                <!-- FORM EDIT DATA JADWAL--->
                <div class="container animate-bottom hide-div " id="container_cek_kursi">
                    <div class="text-center">
                        <h5 class="text-white mt-5">Cek kursi</h5>
                        <div id="layar"
                            class="border rounded border-dark bg-secondary mt-5 font-weight-bold text-center text-white tengah mb-3">
                            LAYAR
                        </div>
                        <div class="table-responsive-lg">
                            <table id="isi_kursi" class="tabel-kursi tengah">

                            </table>
                        </div>
                        <button class="btn btn-secondary mt-2" id="btn_close_cek_kursi">Close</button>
                    </div>
                </div>

                <div class="container animate-bottom" id="container_edit_jadwal">
                    <form class="mt-5" id="form_edit_jadwal" method="POST" action="process/post_edit_jadwal.php"
                        enctype="multipart/form-data">
                        <h3 class="text-center mb-4">Edit Data Jadwal</h3>
                        <!-- <input type="text" readonly class="form-control" id="ejudulbefore" name="ejudulbefore"> -->
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label>Id Jadwal</label>
                                <input type="text" class="form-control" id="eid_jadwal" name="eid_jadwal" readonly>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Tanggal Tayang</label>
                                <input type="date" class="form-control" id="etanggal_tayang" name="etanggal_tayang">
                                <div class="invalid-feedback">
                                    *Tanggal Tayang Tidak boleh kosong
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Jam Tayang</label>
                                <input type="time" class="form-control" id="ejam_tayang" name="ejam_tayang">
                                <div class="invalid-feedback">
                                    *Jam Tayang Tidak boleh kosong
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga</label>
                                <input type="text" class="form-control" id="eharga" name="eharga" data-a-sign="Rp. "
                                    data-a-dec="," data-a-sep=".">
                                <div class="invalid-feedback">
                                    *Harga Tidak boleh kosong
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Studio</label>
                                <select class="form-control" id="estudio" name="estudio">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Film</label>
                            <select class="form-control" id="efilm" name="efilm">
                            </select>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary" type="edit" name="edit" id="submit_edit_jadwal">Edit
                            Film</button>
                    </div>
                </div>

                <div class="container text-center mb-5 animate-bottom">
                    <button type="button" class="btn btn-info" id="btn_edit_data">Edit Data</button>
                    <button type="button" class="btn btn-info" id="btn_cek_kursi">Cek Kursi</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="btn_close_detail">Close</button>
                </div>

            </div>
        </div>
    </div>

</body>

<!--JQUERY-->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/plugin-sort-table/sorttable.js"></script>
<!--JS-->
<script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>

<!--Format Currency-->
<script type="text/javascript" src="js/autoNumeric/autoNumeric.js"></script>
<!--GLOBAL JS-->
<script type="text/javascript" src="js/jadwal.js"></script>
<!--AWAL SCRIPT-->
<script>
$(document).ready(function() {

    $("#harga").autoNumeric("init");
    $("#eharga").autoNumeric("init");

    function proses_tf_df() { // tf = tambah film || df = data film
        $("#data_jadwal").toggleClass("hide-div");
        $("#proses_loading").modal('hide');
    }
    if (<?php if(isset($_SESSION['suksesjadwal'])){echo $_SESSION['suksesjadwal'];}else{echo '0';}?> == 2) {
        $("#proses_error").modal('show');
        $("#data_jadwal").toggleClass("hide-div");
        $("#tambah_jadwal").toggleClass("hide-div");
    }

    if (<?php if(isset($_SESSION['suksesjadwal'])){echo $_SESSION['suksesjadwal'];}else{echo '0';}?> == 1) {
        <?php $_SESSION['suksesjadwal'] = 0?>
        $("#data_jadwal").toggleClass("hide-div");
        $("#proses_loading").modal('show');
        setTimeout(proses_tf_df, 2000);
    }
    if (<?php if(isset($_SESSION['esuksesjadwal'])){echo $_SESSION['esuksesjadwal'];}else{echo '0';}?> == 1) {
        <?php $_SESSION['esuksesjadwal'] = 0?>
        $("#proses_edit_sukes").modal('show');
    }
    //     if (<?php if(isset($_SESSION['esukses'])){echo $_SESSION['esukses'];}else{echo '0';}?> == 2) {
    //         $("#proses_error").modal('show');
    //     }
});
</script>
<!--AKHIR SCRIPT-->

</html>