<?php
include_once "../connect.php";
include "../security_check_proses.php";

if(isset($_GET['id_film'])){
    $sql = "SELECT * FROM film WHERE id_film= ?";
    
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i", $_GET['id_film']);
    $stmt->execute();

    $result =  $stmt->get_result();
    if ($result->num_rows !== 1){
        http_response_code(404);     
        exit();
    }
    echo json_encode($result->fetch_assoc());

}
?>