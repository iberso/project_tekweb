<?php
include "../connect.php";
session_start();

if (isset($_SESSION["loggedinadmin"]) && $_SESSION["loggedinadmin"] === true) {
    $user = $_SESSION["username"];
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
                <a href="studio.php" class="list-group-item list-group-item-action bg-secondary our-font"><i
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
                <div class="row p-2 text-center mt-5 ">
                    <div class="col-md-12">
                        <a class="btn btn-info font-weight-bold mr-2" href="#" id="btn_lihat_studio">Lihat Studio</a>
                        <a class="btn btn-success font-weight-bold mr-2" href="#" id="btn_tambah_studio">Tambah
                            Studio</a>
                    </div>
                </div>

                <div class="row p-2 animate-bottom hide-div" id="tambah_studio">
                    <div class="col-md-6 tengah">
                        <h1 class="mt-5 text-center">Form Tambah Studio</h1>

                        <!-- process/post_studio.php -->
                        <form class="mt-5" id="form_isi_studio" method="POST" action="process/post_studio.php"
                            enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Studio</label>
                                    <input type="text" class="form-control" id="nama_studio" name="nama_studio"
                                        placeholder=" Nama Studio">
                                    <div class="invalid-feedback">
                                        *Nama Studio Tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jumlah Kursi</label>
                                    <select class="form-control" id="jumlah_kursi" name="jumlah_kursi">
                                        <option>192</option>
                                        <option>224</option>
                                        <option>256</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        *Jumlah Kursi Tidak boleh kosong
                                    </div>
                                </div>
                            </div>

                            <?php if(isset($_SESSION['pesanerrorstudio'])){
                                // echo $_SESSION['pesanerror'];
                            }?>
                        </form>
                        <div class="text-center mt-5">
                            <button type="submit" id="submit_studio" name="submit" class="btn btn-primary">Tambah
                                Studio</button>
                        </div>
                    </div>
                </div>

                <!-- DATA STUDIO-->
                <div class="row p-2 animate-bottom" id="data_studio">
                    <div class="col-md-11 mt-3 tengah">
                        <h1 class="text-center">Data Studio</h1>
                        <table class="table text-white mt-5 our-table-hover table-responsive-lg" style="width:100%">
                            <div class="container mt-5">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-primary active">
                                                <input type="radio" name="options" id="radio1" autocomplete="off">
                                                Studio
                                                Aktif
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" id="radio2" autocomplete="off">
                                                Studio
                                                Non-Aktif
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" id="radio3" autocomplete="off"
                                                    checked>
                                                Semua
                                                Studio
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
                                    <th>Id Studio</th>
                                    <th class="align-middle">Nama Studio</th>
                                    <th class="align-middle">Jumlah Kursi</th>
                                    <th class="align-middle">Created By</th>
                                    <th class="align-middle" colspan="2">Detail</th>
                                </tr>
                            </thead>
                            <tbody id="table_studio">

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
                    <h5 class="text-white mt-5"><?php if(isset($_SESSION['pesanerrorstudio'])){
                                echo $_SESSION['pesanerrorstudio'];
                            }?></h5>
                    <h5 class="text-white mt-5"><?php if(isset($_SESSION['epesanerrorstudio'])){
                                echo $_SESSION['epesanerrorstudio'];
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
    <!-- MODAL DETAIL -->
    <div class="modal fade" tabindex="-1" id="modal_detail" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Studio</h5>
                </div>

                <div class="modal-body" id="isi_detail">
                    <h1 id="id_studio"></h1>
                </div>

                <!-- FORM EDIT DATA STUDIO--->
                <div class="container animate-bottom hide-div " id="container_hapus_studio">
                    <div class="text-center">
                        <i class="fas fa-exclamation-circle fa-7x text-warning"></i>
                        <h5 class="text-white mt-5">Apakah Anda Yakin ingin menghapus data ini ?</h5>
                        <div id="tempat_btn_hapus"></div>
                        <button class="btn btn-secondary mt-2" id="btn_batal_hapus">Tidak, Batalkan</button>
                    </div>
                </div>

                <div class="container animate-bottom" id="container_edit_studio">
                    <form class="mt-5" id="form_edit_studio" method="POST" action="process/post_edit_studio.php"
                        enctype="multipart/form-data">
                        <h3 class="text-center mb-4">Edit Data Studio</h3>

                        <div class="form-group">
                            <label>Nama Studio</label>
                            <input type="text" class="form-control" id="enama_studio" name="enama_studio">
                            <div class="invalid-feedback">
                                *Nama Studio Tidak boleh kosong
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Id Studio</label>
                                <input type="text" class="form-control" id="eid_studio" name="eid_studio" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jumlah Kursi</label>
                                <select class="form-control" id="ejumlah_kursi" name="ejumlah_kursi">
                                    <option>192</option>
                                    <option>224</option>
                                    <option>256</option>
                                </select>
                                <div class="invalid-feedback">
                                    *Jumlah Kursi Tidak boleh kosong
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary" type="edit" name="edit" id="submit_edit_studio">Edit
                            Studio</button>
                    </div>
                </div>

                <div class="container text-center mb-5 animate-bottom">
                    <button type="button" class="btn btn-info" id="btn_edit_data">Edit Data</button>
                    <button type="button" class="btn btn-danger" id="btn_hapus_data">Hapus Data</button>
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
<!--GLOBAL JS-->
<script type="text/javascript" src="js/studio.js"></script>

<!--AWAL SCRIPT-->
<script>
$(document).ready(function() {
    console.log(<?php echo $_SESSION['suksesstudio']?>)

    function proses_tf_df() { // tf = tambah film || df = data film
        $("#data_studio").toggleClass("hide-div");
        $("#proses_loading").modal('hide');
    }
    if (<?php if(isset($_SESSION['suksesstudio'])){echo $_SESSION['suksesstudio'];}else{echo '0';}?> == 2) {
        $("#proses_error").modal('show');
        $("#data_studio").toggleClass("hide-div");
        $("#tambah_studio").toggleClass("hide-div");
    }

    if (<?php if(isset($_SESSION['suksesstudio'])){echo $_SESSION['suksesstudio'];}else{echo '0';}?> == 1) {
        <?php $_SESSION['suksesstudio'] = 0?>
        $("#data_studio").toggleClass("hide-div");
        $("#proses_loading").modal('show');

        console.log(<?php echo $_SESSION['suksesstudio']?>)
        setTimeout(proses_tf_df, 2000);
    }
    if (<?php if(isset($_SESSION['esuksesstudio'])){echo $_SESSION['esuksesstudio'];}else{echo '0';}?> == 1) {
        <?php $_SESSION['esuksesstudio'] = 0?>
        $("#proses_edit_sukes").modal('show');
    }
    if (<?php if(isset($_SESSION['esuksesstudio'])){echo $_SESSION['esuksesstudio'];}else{echo '0';}?> == 2) {
        $("#proses_error").modal('show');
    }
});
</script>
<!--AKHIR SCRIPT-->

</html>