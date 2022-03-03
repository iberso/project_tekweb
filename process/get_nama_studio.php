<?php

include_once "../connect.php";
session_start();
require_once "../security_check.php";

if (isset($_GET['id']) && isset($_GET['tgl_t'])) {
    $sql = "SELECT DISTINCT(s.nama_studio),s.id_studio,j.harga,s.jumlah_kursi FROM jadwal j JOIN film f ON j.id_film = f.id_film JOIN studio s ON j.id_studio = s.id_studio WHERE f.id_film = ? AND j.tanggal_tayang = ?
    ORDER BY s.id_studio ASC";
    
    $stmt = $link->prepare($sql);
    $stmt->bind_param("is",$_GET['id'],$_GET['tgl_t']);
    $stmt->execute();
    $result =  $stmt->get_result();
    
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    
}
?>