<?php
include_once "../connect.php";
session_start();
require_once "../security_check.php";

if(isset($_GET['id_pesanan'])){
$id_pesan = $_GET['id_pesanan'];

// prepare and bind
$stmt = $link->prepare("DELETE FROM pesanan WHERE id_user = ? AND id_pesanan = ?");
$stmt->bind_param("ii",$_SESSION['id_user'],$id_pesan);
$stmt->execute();

}
?>