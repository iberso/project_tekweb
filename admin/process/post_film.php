<?php 

include_once "../connect.php";
include "../security_check_proses.php";
// session_start();
$_SESSION['pesanerror'] = "";
$_SESSION['sukses']  = 0;

function input_sterilizer($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// prepare and bind
$stmt = $link->prepare("INSERT INTO film (judul_film,sutradara,genre,produksi,sinopsi,durasi,poster,kategori_umur,created_by) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssissi",$judul_film,$sutradara,$genre,$produksi,$sinopsi,$durasi,$poster,$kategori,$id_admin);

        $judul_film = input_sterilizer($_POST['judul_film']); 
        $sutradara = input_sterilizer($_POST['sutradara']);
        $genre = input_sterilizer($_POST['genre']);
        $produksi = input_sterilizer($_POST['produksi']);
        $sinopsi = input_sterilizer($_POST['sinopsi']);
        $durasi = $_POST['durasi'];
        $kategori = input_sterilizer($_POST['kategori']);
        $id_admin = $_SESSION['id_admin'];

        $file = $_FILES['poster'];
        $namaPoster = $_FILES['poster']['name'];    
        $tmpNamaPoster = $_FILES['poster']['tmp_name'];
        $sizePoster = $_FILES['poster']['size'];
        $errorPoster = $_FILES['poster']['error'];
        $tipePoster = $_FILES['poster']['type'];

        $fileExt = explode('.',$namaPoster);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt,$allowed)){
            if($errorPoster === 0){
                if($sizePoster < 1000000){ //ini 1MB
                    $namabaru = $judul_film.".".$fileActualExt;
                    $fileDestination = '../../img/poster/'.$namabaru;
                    move_uploaded_file($tmpNamaPoster,$fileDestination);
                    
                    $poster = "img/poster/".$namabaru;

                    if($stmt->execute()){
                        $_SESSION['sukses'] = 1;
                        header('Location: ../film.php');
                        exit;
                    }else{
                        $_SESSION['pesanerror'] = "Data Film Gagal ditambahkan";
                        $_SESSION['sukses'] = 2;
                    }
                }else{
                    $_SESSION['pesanerror'] = "Ukuran file melebihi 1 Mb";
                    $_SESSION['sukses'] = 2;
                }
            }else{
                $_SESSION['pesanerror'] = "Error mengupload gambar";
                $_SESSION['sukses'] = 2;
            }
        }else{
            $_SESSION['pesanerror'] = "Ini bukan gambar berformat jpg, jpeg, atau png";
            $_SESSION['sukses'] = 2;
        }
        header('Location: ../index.php');


?>