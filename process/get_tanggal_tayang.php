<?php

include_once "../connect.php";
session_start();
require_once "../security_check.php";

if (isset($_GET['id'])) {
    $sql = "SELECT DISTINCT(DATE_FORMAT(j.tanggal_tayang,'%d %M %Y')) AS tanggal_tayang,j.tanggal_tayang AS tanggal_val,j.harga AS harga_fil FROM jadwal j JOIN film f ON j.id_film = f.id_film JOIN studio s ON j.id_studio = s.id_studio
    WHERE f.id_film = ? AND j.tanggal_tayang >= CURDATE()
    ORDER BY j.tanggal_tayang ASC";
        
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();

    $result =  $stmt->get_result();
    
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>