<?php
include_once "../connect.php";
session_start();
require_once "../security_check.php";

    $sql = "SELECT * FROM film WHERE id_film = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();

    $result =  $stmt->get_result();

    if ($result->num_rows !== 1){
        http_response_code(404);     
        exit();
    }
    echo json_encode($result->fetch_assoc());

?>