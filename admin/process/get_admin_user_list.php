<?php
include_once "../connect.php";
include "../security_check_proses.php";

    $sql = "SELECT id_admin,username,role FROM admin";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>