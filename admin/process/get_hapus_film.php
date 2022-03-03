<?php 

include_once "../connect.php";
include "../security_check_proses.php";

$stmt = $link->prepare("DELETE FROM film WHERE id_film = ?");
$stmt->bind_param("i",$id_film);
$id_film = $_GET['id_film'];
$judul_film = $_GET['j_f'];

if($stmt->execute()){
    unlink('../../img/poster/'.$judul_film.'.jpg');
    header('Location: ../film.php');
}else{
    header('Location: ../index.php');
}
?>