<?php 
include_once "../connect.php";
include "../security_check_proses.php";

if(isset($_GET['id_admin'])){
$stmt = $link->prepare("DELETE FROM admin WHERE id_admin = ? AND role <> 1");
$stmt->bind_param("i",$id_admin);
$id_admin = $_GET['id_admin'];
if($stmt->execute()){
    header('Location: ../operator_admin.php');
}else{
    header('Location: ../index.php');
}
}
?>