<?php 

include_once "../connect.php";
include "../security_check_proses.php";

if(isset($_GET['id_studio'])){
$stmt = $link->prepare("UPDATE studio SET status = ? WHERE id_studio = ?");
$stmt->bind_param("ii",$bol,$id_studio);
$id_studio = $_GET['id_studio'];
$bol = 0;
if($stmt->execute()){
    header('Location: ../studio.php');
}else{
    header('Location: ../index.php');
}
}
?>