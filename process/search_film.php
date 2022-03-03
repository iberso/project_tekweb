<?php
include_once "../connect.php";

if (isset($_GET['q'])) {
    $cSearch = $_GET['q'];
    $sql = "SELECT id_film, judul_film FROM film WHERE judul_film like '%$cSearch%' && id_film IN (SELECT id_film FROM jadwal)";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>