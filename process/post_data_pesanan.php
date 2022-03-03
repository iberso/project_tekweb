<?php
include_once "../connect.php";
session_start();
require_once "../security_check.php";

// prepare and bind
$stmt = $link->prepare("INSERT INTO pesanan (jam_pesan,tanggal_pesan,status,uuid,id_user,id_jadwal) VALUES (CURRENT_TIME(),CURDATE(),1,uuid(),?,?)");
$stmt->bind_param("ii",$id_user,$id_jadwal);
$id_user = $_SESSION['id_user'];

$data = json_decode(file_get_contents('php://input'), true);

$id_user = $_SESSION['id_user'];
$id_jadwal = $data['id_jadwal'];

$stmt->execute();
$last_id_pesanan = $link->insert_id;
// echo "last id : ".$last_id_pesanan;
$_SESSION['id_pesanan'] = $last_id_pesanan;

$stmt = $link->prepare("INSERT INTO kursi(pos_x,pos_y,id_pesanan,id_studio) VALUES (?,?,?,?)");
$stmt->bind_param("iiii",$posX,$posY,$last_id_pesanan,$id_studio);

$id_studio = $data['id_studio'];

foreach ($data['kursi'] as $value) {
    $posX = $value['posX'];
    $posY = $value['posY'];
    $stmt->execute();
}

?>