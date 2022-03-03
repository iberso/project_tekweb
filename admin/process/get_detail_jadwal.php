<?php

include_once "../connect.php";
include "../security_check_proses.php";

if(isset($_GET['id_jadwal'])){
    $sql = "SELECT j.id_jadwal,DATE_FORMAT(j.tanggal_tayang,'%d %M %Y') AS tanggal_tampil,DATEDIFF(j.tanggal_tayang,CURDATE())AS jarak_tanggal,j.tanggal_tayang,REPLACE(FORMAT(harga, 0),',','.') AS harga,s.nama_studio,f.judul_film,j.id_film,f.poster,s.nama_studio,j.id_studio,SUBSTRING(j.jam_tayang,1,5) AS jam_val,s.jumlah_kursi,a.username as created_by FROM jadwal j JOIN admin a ON j.created_by = a.id_admin JOIN film f ON j.id_film = f.id_film JOIN studio s ON j.id_studio = s.id_studio WHERE j.id_jadwal = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id_jadwal']);
    $stmt->execute();

    $result =  $stmt->get_result();
    if ($result->num_rows !== 1){
        http_response_code(404);     
        exit();
    }
    echo json_encode($result->fetch_assoc());

}
?>