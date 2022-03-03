<?php

include_once "../connect.php";
session_start();
require_once "../security_check.php";

if (isset($_GET['id']) && isset($_GET['tgl_t']) && isset($_GET['id_std'])) {
    $sql = "SELECT SUBSTRING(j.jam_tayang,1,5) AS jam_val,j.id_jadwal,j.harga FROM jadwal j JOIN film f ON j.id_film = f.id_film JOIN studio s ON j.id_studio = s.id_studio
    WHERE f.id_film = ? AND j.tanggal_tayang = ? AND s.id_studio = ?
    ORDER BY jam_val ASC";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("isi",$_GET['id'],$_GET['tgl_t'],$_GET['id_std']);
    $stmt->execute();
    $result =  $stmt->get_result();
    
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    
}
?>