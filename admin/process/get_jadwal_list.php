<?php
include_once "../connect.php";
include "../security_check_proses.php";

    $sql = "SELECT j.id_jadwal,DATE_FORMAT(j.tanggal_tayang,'%d %M %Y') AS tanggal_tampil,DATEDIFF(j.tanggal_tayang,CURDATE())AS jarak_tanggal,j.tanggal_tayang,REPLACE(FORMAT(harga, 0),',','.') AS harga,s.nama_studio,f.judul_film,s.nama_studio,SUBSTRING(j.jam_tayang,1,5) AS jam_val,a.username as created_by FROM jadwal j JOIN admin a ON j.created_by = a.id_admin JOIN film f ON j.id_film = f.id_film JOIN studio s ON j.id_studio = s.id_studio";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>