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
                <a href="film.php" class="list-group-item list-group-item-action bg-secondary our-font"><i
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
                <div class="row p-2 text-center mt-5 ">
                    <div class="col-md-12">
                        <a class="btn btn-info font-weight-bold mr-2" href="#" id="btn_lihat_film">Lihat Film</a>
                        <a class="btn btn-success font-weight-bold mr-2" href="#" id="btn_tambah_film">Tambah Film</a>
                    </div>
                </div>

                <div class="row p-2 animate-bottom hide-div" id="tambah_film">
                    <div class="col-md-6 tengah">
                        <h1 class="mt-5 text-center">Form Tambah Film</h1>

                        <!-- process/post_film.php -->
                        <form class="mt-5" id="form_isi_film" method="POST" action="process/post_film.php"
                            enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Judul Film</label>
                                    <input type="text" class="form-control" id="judul_film" name="judul_film"
                                        placeholder="Judul Film">
                                    <div class="invalid-feedback">
                                        *Judul Tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sutradara</label>
                                    <input type="text" class="form-control" name="sutradara" id="sutradara"
                                        placeholder="Sutradara">
                                    <div class="invalid-feedback">
                                        *Sutradara Tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Genre</label>
                                    <input type="text" class="form-control" name="genre" id="genre" placeholder="Genre">
                                    <div class="invalid-feedback">
                                        *Genre Tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Produksi</label>
                                    <input type="text" class="form-control" name="produksi" id="produksi"
                                        placeholder="Produksi">
                                    <div class="invalid-feedback">
                                        *Produksi Tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Sinopsi</label>
                                <textarea class="form-control" name="sinopsi" rows="3" id="sinopsi"
                                    placeholder="Sinopsi"></textarea>
                                <div class="invalid-feedback">
                                    *Sinopsi Tidak boleh kosong
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Durasi</label>
                                    <input type="number" class="form-control" name="durasi" id="durasi">
                                    <div class="invalid-feedback">
                                        *durasi Tidak boleh kosong
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kategori</label>
                                    <select class="form-control" name="kategori">
                                        <option>SU</option>
                                        <option>R13+</option>
                                        <option>D17+</option>
                                    </select>
                                </div>
                            </div>

                            <input type="file" name="poster" id="poster">
                            <div class="invalid-feedback">
                                *Poster Tidak boleh kosong
                            </div>
                            <?php if(isset($_SESSION['pesanerror'])){
                                // echo $_SESSION['pesanerror'];
                            }?>
                        </form>
                        <div class="text-center mt-5">
                            <button type="submit" id="submit_film" name="submit" class="btn btn-primary">Tambah
                                Film</button>
                        </div>
                    </div>
                </div>

                <!-- DATA FILM-->
                <div class="row p-2 animate-bottom" id="data_film">
                    <div class="col-md-11 mt-3 tengah">
                        <h1 class="text-center">Data Film</h1>
                        <table class="table text-white mt-5 our-table-hover table-responsive-lg" style="width:100%">
                            <div class="container mt-5">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-primary active">
                                                <input type="radio" name="options" id="radio1" autocomplete="off"> Film
                                                Aktif
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" id="radio2" autocomplete="off"> Film
                                                Non-Aktif
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" id="radio3" autocomplete="off"
                                                    checked>
                                                Semua
                                                Film
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
                                    <th>Id Film</th>
                                    <th class="align-middle">Judul Film</th>
                                    <th class="align-middle">Sutradara</th>
                                    <th class="align-middle">Genre</th>
                                    <th class="align-middle">Produksi</th>
                                    <th class="align-middle">Durasi</th>
                                    <th>Kategori Umur</th>
                                    <th>Created By</th>
                                    <th class="align-middle" colspan="2">Detail</th>
                                </tr>
                            </thead>
                            <tbody id="table_film">

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
                    <h5 class="modal-title">Detail Film</h5>
                </div>

                <div class="modal-body" id="isi_detail">
                    <h1 id="id_film"></h1>
                </div>
                <!-- FORM EDIT DATA FILM--->
                <div class="container animate-bottom hide-div " id="container_hapus_film">
                    <div class="text-center">
                        <i class="fas fa-exclamation-circle fa-7x text-warning"></i>
                        <h5 class="text-white mt-5">Apakah Anda Yakin ingin menghapus data ini ?</h5>
                        <div id="tempat_btn_hapus"></div>
                        <button class="btn btn-secondary mt-2" id="btn_batal_hapus">Tidak, Batalkan</button>
                    </div>
                </div>
                <div class="container animate-bottom" id="container_edit_film">
                    <form class="mt-5" id="form_edit_film" method="POST" action="process/post_edit_film.php"
                        enctype="multipart/form-data">
                        <h3 class="text-center mb-4">Edit Data Film</h3>
                        <input type="text" readonly class="form-control" id="ejudulbefore" name="ejudulbefore">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Judul Film</label>
                                <input type="text" class="form-control" id="ejudul_film" name="ejudul_film">
                                <div class="invalid-feedback">
                                    *Judul Film Tidak boleh kosong
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Sutradara</label>
                                <input type="text" class="form-control" id="esutradara" name="esutradara">
                                <div class="invalid-feedback">
                                    *Sutradara Tidak boleh kosong
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Genre</label>
                                <input type="text" class="form-control" id="egenre" name="egenre">
                                <div class="invalid-feedback">
                                    *Genre Tidak boleh kosong
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Produksi</label>
                                <input type="text" class="form-control" id="eproduksi" name="eproduksi">
                                <div class="invalid-feedback">
                                    *Produksi Tidak boleh kosong
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sinopsi</label>
                            <textarea class="form-control" id="esinopsi" name="esinopsi" rows="5"></textarea>
                            <div class="invalid-feedback">
                                *Sinopsi Tidak boleh kosong
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label>id_film</label>
                                <input type="text" readonly class="form-control" id="eid_film" name="eid_film">
                            </div>
                            <div class="form-group col-md-5">
                                <label>Durasi</label>
                                <input type="number" class="form-control" id="edurasi" name="edurasi">
                                <div class="invalid-feedback">
                                    *Durasi Tidak boleh kosong
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <label>Kategori</label>
                                <select class="form-control" id="ekategori" name="ekategori">
                                    <option>SU</option>
                                    <option>R13+</option>
                                    <option>D17+</option>
                                </select>
                                <!-- <div class="text-danger">*Kategori perlu diisi ulang</div> -->
                            </div>
                        </div>

                        <input type="file" name="eposter" id="eposter">
                        <div class="invalid-feedback">
                            *Poster Tidak boleh kosong
                        </div>
                        <!-- pesan error here -->
                    </form>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary" type="edit" name="edit" id="submit_edit_film">Edit
                            Film</button>
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
<script type="text/javascript" src="js/film.js"></script>

<!--AWAL SCRIPT-->
<script>
$(document).ready(function() {

    function proses_tf_df() { // tf = tambah film || df = data film
        $("#data_film").toggleClass("hide-div");
        $("#proses_loading").modal('hide');
    }
    if (<?php if(isset($_SESSION['sukses'])){echo $_SESSION['sukses'];}else{echo '0';}?> == 2) {
        $("#proses_error").modal('show');
        $("#data_film").toggleClass("hide-div");
        $("#tambah_film").toggleClass("hide-div");
    }

    if (<?php if(isset($_SESSION['sukses'])){echo $_SESSION['sukses'];}else{echo '0';}?> == 1) {
        <?php $_SESSION['sukses'] = 0?>
        $("#data_film").toggleClass("hide-div");
        $("#proses_loading").modal('show');
        setTimeout(proses_tf_df, 2000);
    }
    if (<?php if(isset($_SESSION['esukses'])){echo $_SESSION['esukses'];}else{echo '0';}?> == 1) {
        <?php $_SESSION['esukses'] = 0?>
        $("#proses_edit_sukes").modal('show');
    }
    if (<?php if(isset($_SESSION['esukses'])){echo $_SESSION['esukses'];}else{echo '0';}?> == 2) {
        $("#proses_error").modal('show');
    }
});
</script>
<!--AKHIR SCRIPT-->

</html>