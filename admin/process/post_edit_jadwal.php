<?php 

include_once "../connect.php";
include "../security_check_proses.php";
// session_start();
$_SESSION['epesanerrorjadwal'] = "";
$_SESSION['esuksesjadwal']  = 0;

// prepare and bind
$stmt = $link->prepare("UPDATE jadwal SET tanggal_tayang = ?,jam_tayang = ?,harga = ?,id_studio = ?,id_film = ?,created_by = ? WHERE id_jadwal = ?");
$stmt->bind_param("ssiiiii",$tanggal_tayang,$jam_tayang,$harga,$id_studio,$id_film,$created_by,$id_jadwal);
        $tanggal_tayang = $_POST['etanggal_tayang'];
        $jam_tayang = $_POST['ejam_tayang'];
        $harga = str_replace(["Rp. ",".",",00"],"",$_POST['eharga']);
        $id_studio = $_POST['estudio'];
        $id_film = $_POST['efilm'];
        $id_jadwal = $_POST['eid_jadwal'];
        $created_by = $_SESSION['id_admin']; 
 
        
        if($stmt->execute()){
            $_SESSION['esuksesjadwal'] = 1;
            header('Location: ../jadwal.php');
            exit;
        }else{
            $_SESSION['epesanerrorjadwal'] = "Error";
            header('Location: ../index.php');
        }
?>