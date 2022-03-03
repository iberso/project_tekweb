<?php

require_once "../connect.php";
session_start();
if (isset($_SESSION["loggedinadmin"]) && $_SESSION["loggedinadmin"] === true) {
    header("location:index.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        //pre sql statment  

        $sql = "SELECT id_admin,username,password,role FROM admin WHERE username = ?";
   
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
     
            $param_username = $username;
            //attempt to execute the pre stat
            if (mysqli_stmt_execute($stmt)) {
                //store result
                mysqli_stmt_store_result($stmt);

                //check if username exist, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    //bind result var
                    mysqli_stmt_bind_result($stmt, $id_admin, $username,$hsh_psd,$role);

                    if (mysqli_stmt_fetch($stmt)) {
                        $verify = password_verify($password, $hsh_psd);
                        if ($verify) {
                            //passwrd is correct, so start new session
                            
                            session_start();

                            $_SESSION["loggedinadmin"] = true;
                            $_SESSION["id_admin"] = $id_admin;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;

                            header("location: index.php");
                        } else {
                            $password_err = "The password invalid";
                        }
                    }
                } else {
                    $username_err = "No account found";
                }
            } else {
                echo "Ops someting went wrong";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OUR CINEMA21 [LOGIN ADMIN]</title>
    <link rel="icon" href="../img/XXI.ico">
    <!--BOOTSTRAPS-->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/our-cinema-style.css">
    <!--JS-->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <!--FONT AWESOME-->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free-5.15.1-web/css/all.css">
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free-5.15.1-web/css/all.css">
</head>

<style>
.tengah {
    margin-left: auto;
    margin-right: auto;
}

.nav-col {
    background-color: #16697a;
}
</style>

<body class="color-back">

    <!--AWAL NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top shadow-sm">
        <div class="container">
            <a class="navbar-brand tengah" href="home.php">
                <img src="../img/Our_Cinema_XXI.png" width="300" height="40" alt="logo cinemax">
            </a>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->
    <?php
echo password_hash("admin123", PASSWORD_DEFAULT);
?>
    <div class="container" style="margin-top:100px;">
        <div class="row">
            <div
                class="col-10 col-sm-10 col-md-7 col-lg-6 shadow card-color-setting tengah p-4 rounded-lg our-color text-white">
                <h2 class="text-center">Login Admin</h2>
                <form method="POST">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="col mt-5">
                        <input type="submit" id="btnlogin" class="btn btn-block w-50 tengah color-obj font-weight-bold"
                            value="Login">
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>