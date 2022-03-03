<?php

include_once "../connect.php";
session_start();
require_once "../security_check.php";

if (isset($_GET['id']) && isset($_GET['tgl_t']) && isset($_GET['jm_t']) && isset($_GET['id_std'])) {
    $sql = "SELECT k.pos_x, k.pos_y,j.id_film FROM kursi k JOIN pesanan p ON k.id_pesanan = p.id_pesanan JOIN jadwal j ON p.id_jadwal = j.id_jadwal
    WHERE j.id_film = ? AND j.tanggal_tayang = ? AND j.id_studio = ? AND SUBSTRING(j.jam_tayang,1,5) = ?";
    
    $stmt = $link->prepare($sql);
    $stmt->bind_param("isis",$_GET['id'],$_GET['tgl_t'],$_GET['id_std'],$_GET['jm_t']);
    $stmt->execute();
    $result =  $stmt->get_result();
    
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>