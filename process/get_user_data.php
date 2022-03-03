<?php

include_once "../connect.php";
session_start();
require_once "../security_check.php";

if (isset($_GET['id_user'])) {
    $sql = "SELECT CONCAT(firstname,' ',lastname) AS nama,email,username FROM user WHERE id_user = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id_user']);
    $stmt->execute();

    $result =  $stmt->get_result();

    if ($result->num_rows !== 1){
        http_response_code(404);     
        exit();
    }
    echo json_encode($result->fetch_assoc());
}

?>