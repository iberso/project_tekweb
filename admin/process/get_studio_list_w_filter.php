<?php

include_once "../connect.php";
include "../security_check_proses.php";

 if(isset($_GET['s'])){
    $sql = "SELECT s.id_studio,s.nama_studio,s.jumlah_kursi,a.username as created_by FROM studio s JOIN admin a ON s.created_by = a.id_admin WHERE status = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i",$status);
    $status = $_GET['s'];
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>