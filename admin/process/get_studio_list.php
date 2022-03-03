<?php
include_once "../connect.php";
include "../security_check_proses.php";

    $sql = "SELECT s.id_studio,s.nama_studio,s.jumlah_kursi,s.status,a.username as created_by FROM studio s JOIN admin a ON s.created_by = a.id_admin";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>