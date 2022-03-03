<?php

include_once "../connect.php";
include "../security_check_proses.php";

if(isset($_GET['id_studio'])){
    $sql = "SELECT s.id_studio,s.nama_studio,s.jumlah_kursi,s.status,a.username AS created_by FROM studio s JOIN admin a ON s.created_by = a.id_admin WHERE id_studio = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id_studio']);
    $stmt->execute();

    $result =  $stmt->get_result();
    if ($result->num_rows !== 1){
        http_response_code(404);     
        exit();
    }
    echo json_encode($result->fetch_assoc());

}
?>