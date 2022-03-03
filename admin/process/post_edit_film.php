<?php 
include_once "../connect.php";
include "../security_check_proses.php";
$_SESSION['epesanerror'] = "";
$_SESSION['esukses']  = 0;

function input_sterilizer($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// prepare and bind
$stmt = $link->prepare("UPDATE film SET judul_film = ?, sutradara = ?, genre = ?,produksi = ?,sinopsi = ?,durasi = ?,poster = ?,kategori_umur = ?,created_by = ? WHERE id_film = ?");
$stmt->bind_param("sssssissii",$judul_film,$sutradara,$genre,$produksi,$sinopsi,$durasi,$poster,$kategori,$id_admin,$id_film);

        $judul_film = input_sterilizer($_POST['ejudul_film']); 
        $judul_film_before = $_POST['ejudulbefore'];
        $sutradara = input_sterilizer($_POST['esutradara']);
        $genre = input_sterilizer($_POST['egenre']);
        $produksi = input_sterilizer($_POST['eproduksi']);
        $sinopsi = input_sterilizer($_POST['esinopsi']);
        $durasi = $_POST['edurasi'];
        $kategori = input_sterilizer($_POST['ekategori']);
        $id_admin = $_SESSION['id_admin'];
        $id_film = $_POST['eid_film'];

        $file = $_FILES['eposter'];
        $namaPoster = $_FILES['eposter']['name'];    
        $tmpNamaPoster = $_FILES['eposter']['tmp_name'];
        $sizePoster = $_FILES['eposter']['size'];
        $errorPoster = $_FILES['eposter']['error'];
        $tipePoster = $_FILES['eposter']['type'];

        $fileExt = explode('.',$namaPoster);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt,$allowed)){
            if($errorPoster === 0){
                if($sizePoster < 1000000){ //ini 1MB
                    $namabaru = $judul_film.".".$fileActualExt;
                    $fileDestination = '../../img/poster/'.$namabaru;
                    unlink('../../img/poster/'.$judul_film_before.$fileActualExt);
                    move_uploaded_file($tmpNamaPoster,$fileDestination);
                    
                    $poster = "img/poster/".$namabaru;

                    if($stmt->execute()){
                        $_SESSION['esukses'] = 1;
                        header('Location: ../film.php');
                        
                        exit;
                    }else{
                        $_SESSION['epesanerror'] = "Data Film Gagal diupdate";
                        $_SESSION['esukses'] = 2;
                    }
                }else{
                    $_SESSION['epesanerror'] = "Ukuran file melebihi 1 Mb";
                    $_SESSION['esukses'] = 2;
                }
            }else{
                $_SESSION['epesanerror'] = "Error mengupload gambar";
                $_SESSION['esukses'] = 2;
            }
        }else{
            $_SESSION['epesanerror'] = "Ini bukan gambar berformat jpg, jpeg, atau png";
            $_SESSION['esukses'] = 2;
        }
        header('Location: ../film.php');

?>