<?php 

include_once "../connect.php";
include "../security_check_proses.php";
// session_start();
$_SESSION['suksesjadwal']  = 0;

// prepare and bind
$stmt = $link->prepare("INSERT INTO jadwal (tanggal_tayang,jam_tayang,harga,id_studio,id_film,created_by) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("ssiiii",$tanggal_tayang,$jam_tayang,$harga,$id_studio,$id_film,$created_by);
        $tanggal_tayang = $_POST['tanggal_tayang'];
        $jam_tayang = $_POST['jam_tayang'];
        $harga = str_replace(["Rp. ",".",",00"],"",$_POST['harga']);
        $id_studio = $_POST['studio'];
        $id_film = $_POST['film'];
        $created_by = $_SESSION['id_admin'];
    
        if($stmt->execute()){
            $_SESSION['suksesjadwal'] = 1;
            header('Location: ../jadwal.php');
            exit;
        }else{
            header('Location: ../index.php');
        }

?>