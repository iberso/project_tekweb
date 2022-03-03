<?php 

include_once "../connect.php";
include "../security_check_proses.php";
// session_start();
$_SESSION['pesanerrorstudio'] = "";
$_SESSION['suksesstudio']  = 0;

function input_sterilizer($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// prepare and bind
$stmt = $link->prepare("INSERT INTO studio (nama_studio,jumlah_kursi,created_by) VALUES (?,?,?)");
$stmt->bind_param("sii",$nama_studio,$jumlah_kursi,$id_admin);

        $nama_studio = input_sterilizer($_POST['nama_studio']); 
        $jumlah_kursi = $_POST['jumlah_kursi'];
        $id_admin = $_SESSION['id_admin'];

        if($stmt->execute()){
                        $_SESSION['suksesstudio'] = 1;
                        header('Location: ../studio.php');
                        exit;
                    }else{
                        $_SESSION['pesanerrorstudio'] = "Error";
                        header('Location: ../index.php');
                    }

?>