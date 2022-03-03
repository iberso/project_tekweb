<?php
include_once "../connect.php";
session_start();
require_once "../security_check.php";

if(isset($_GET['id_pesanan'])){
$_SESSION['id_pesanan'] = $_GET['id_pesanan'];
}

    $sql = "SELECT p.id_pesanan,p.uuid,CONCAT(u.firstname,' ',u.lastname) as nama,f.judul_film,DATE_FORMAT(j.tanggal_tayang,'%d %M %Y') AS tanggal_tayang,SUBSTRING(j.jam_tayang,1,5) AS jam_tayang,DATEDIFF(j.tanggal_tayang,CURDATE())AS jarak_tanggal,UPPER(s.nama_studio) AS nama_studio FROM pesanan p JOIN user u ON p.id_user = u.id_user JOIN jadwal j ON p.id_jadwal = j.id_jadwal JOIN film f ON j.id_film = f.id_film JOIN studio s ON j.id_studio = s.id_studio WHERE p.id_pesanan = ? AND u.id_user = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("ii",$_SESSION['id_pesanan'],$_SESSION['id_user']);
    $stmt->execute();

    $result =  $stmt->get_result();

    echo json_encode($result->fetch_assoc());

?>