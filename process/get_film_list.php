<?php
include_once "../connect.php";

if (isset($_GET['id'])) {
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

} else {
    $sql = "SELECT * FROM film WHERE id_film IN (SELECT id_film FROM jadwal)";
    // $sql = "SELECT id_film, judul_film, poster FROM film";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result =  $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));

}
?>