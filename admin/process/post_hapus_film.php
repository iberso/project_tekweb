<?php 

include_once "../connect.php";
include "../security_check_proses.php";

if(isset($_GET['id_film'])){
$stmt = $link->prepare("UPDATE film SET is_delete = ? WHERE id_film = ?");
$stmt->bind_param("ii",$bol,$id_film);
$id_film = $_GET['id_film'];
$bol = 1;
if($stmt->execute()){
    header('Location: ../film.php');
}else{
    header('Location: ../index.php');
}
}
?>