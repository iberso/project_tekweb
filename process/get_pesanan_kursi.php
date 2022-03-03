<?php

include_once "../connect.php";
session_start();
require_once "../security_check.php";

if (isset($_GET['id_pesanan'])) {
    $sql = "SELECT pos_x,pos_y FROM kursi WHERE id_pesanan = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id_pesanan']);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));

}
?>