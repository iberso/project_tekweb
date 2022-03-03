<?php
include_once "../connect.php";
session_start();
require_once "../security_check.php";

// prepare and bind
$stmt = $link->prepare("INSERT INTO pesanan (jam_pesan,tanggal_pesan,status,uuid,id_user,id_jadwal) VALUES (CURRENT_TIME(),CURDATE(),1,uuid(),?,?)");
$stmt->bind_param("ii",$id_user,$id_jadwal);
$id_user = $_SESSION['id_user'];

$data = json_decode(file_get_contents('php://input'), true);
echo "id jadwal : ". $data['id_jadwal'];
echo " id studio : ".$data['id_studio'];
// echo " pos_kursi : ".$data['kursi'][1]['posX'].",".$data['kursi'][1]['posY'];
echo " POSISI DUDUK : ";
foreach ($data['kursi'] as $value) {
    echo "(".$value['posX'].",".$value['posY'].")";
  }
echo " id user : ".$_SESSION['id_user'];
// $stmt->execute();
?>