<?php 

include_once "../connect.php";
include "../security_check_proses.php";
// session_start();
$_SESSION['epesanerrorstudio'] = "";
$_SESSION['esuksesstudio']  = 0;

function input_sterilizer($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// prepare and bind
$stmt = $link->prepare("UPDATE studio SET nama_studio = ?, jumlah_kursi = ?,created_by = ? WHERE id_studio = ?");
$stmt->bind_param("siii",$nama_studio,$jumlah_kursi,$id_admin,$id_studio);

        $nama_studio = input_sterilizer($_POST['enama_studio']); 
        $jumlah_kursi = $_POST['ejumlah_kursi'];
        $id_studio = $_POST['eid_studio'];
        $id_admin = $_SESSION['id_admin'];
// var_dump($stmt);
        if($stmt->execute()){
            $_SESSION['esuksesstudio'] = 1;
            header('Location: ../studio.php');
            exit;
        }else{
            $_SESSION['epesanerrorstudio'] = "Error";
            header('Location: ../index.php');
        }
?>