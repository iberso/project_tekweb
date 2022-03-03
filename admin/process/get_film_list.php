<?php
include_once "../connect.php";
include "../security_check_proses.php";

    $sql = "SELECT f.id_film,f.judul_film,f.sutradara,f.genre,f.produksi,f.durasi,f.kategori_umur,f.is_delete,a.username as created_by FROM film f JOIN admin a ON f.created_by = a.id_admin";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>