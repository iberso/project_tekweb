<?php

include_once "../connect.php";
include "../security_check_proses.php";

 if(isset($_GET['d'])){
    $sql = "SELECT f.id_film,f.judul_film,f.sutradara,f.genre,f.produksi,f.durasi,f.kategori_umur,a.username as created_by FROM film f JOIN admin a ON f.created_by = a.id_admin WHERE is_delete = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("i",$is_delete);
    $is_delete = $_GET['d'];
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>