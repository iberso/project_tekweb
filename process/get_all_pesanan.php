<?php
include_once "../connect.php";
session_start();
require_once "../security_check.php";

    $sql = "SELECT f.judul_film,SUBSTRING(j.jam_tayang,1,5) AS jam_tayang,DATE_FORMAT(j.tanggal_tayang,'%d %M %Y') AS tanggal_tayang,f.poster,p.id_pesanan,UPPER(s.nama_studio) AS nama_studio FROM pesanan p JOIN jadwal j ON p.id_jadwal = J.id_jadwal JOIN studio s ON j.id_studio = s.id_studio JOIN film f ON J.id_film = f.id_film WHERE p.id_user = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id_user']);
    $stmt->execute();

    $result =  $stmt->get_result();

    echo json_encode($result->fetch_all(MYSQLI_ASSOC));

?>