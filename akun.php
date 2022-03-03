<?php
session_start();
require_once "connect.php";
require_once "security_check.php";

$id_user = $_SESSION["id_user"];
$password = $confirm_password = "";
$password_err = $confirm_password_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
   // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sqlupdate = "UPDATE user SET password = ? WHERE id_user= ?";
        if($stmt = mysqli_prepare($link, $sqlupdate)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_id);
            
            // Set parameters
            $param_id = $_SESSION["id_user"];
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $_SESSION["loggedin"] = false;
                header("location: logout.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OUR CINEMA21 [AKUN]</title>
    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS AND OUR CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/our-cinema-style.css">
    <!--JS-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <!--FONT AWESOME-->
    <link rel="stylesheet" type="text/css" href="fontawesome-free-5.15.1-web/css/all.css">
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--FONTAWESOME-->
    <link rel="stylesheet" type="text/css" href="fontawesome-free-5.15.1-web/css/all.css">
</head>

<body class="color-back">
    <!--AWAL NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <img src="img/Our_Cinema_XXI.png" width="300" height="40" alt="logo cinemax">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto" style="font-size:13pt;">
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#"><i class='fas fa-user-circle mr-1'></i> -->
                        <?php 
                        if($user == ""){
                            echo "<a class='nav-link' href='login.php'><i class='fas fa-user-circle mr-1'></i>Akun</a>";
                        }else{
                            echo "<a class='nav-link' href='akun.php'><i class='fas fa-user-circle mr-1'></i>".ucfirst($user)."</a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="fas fa-home mr-1"></i>Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesanan.php"><i class="fas fa-shopping-cart mr-1"></i>Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt mr-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->

    <div class="container" style="margin-top: 120px;">
        <div class="row">
            <div class="col-md-4 mb-4" id="datauserkanan">

            </div>
            <div class="col-md-8 card-color-setting our-border text-white ">
                <div id="datauserkiri"></div>
                <h4 class="mt-5">Reset Password</h4>
                <form method="POST">
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control"
                            value="<?php echo $confirm_password; ?>">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <input type="submit" class="btn color-obj" value="Change Password">
                </form>
            </div>
        </div>
    </div>
    <!--END OFF DIV CONTAINER -->
</body>

<script>
$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: 'process/get_user_data.php?id_user=<?php echo $_SESSION['id_user']?>',
        success: function(response) {
            try {
                response = $.parseJSON(response);
                var data1 =
                    "<div class='card shadow text-white text-center card-color-setting our-border'>  <img src='img/user.png' width='250px' height='250px' class='tengah mt-4'> <div class='card-body'><h5 class='card-title'>" +
                    response.nama + "</h5><h5 class='card-title'>" +
                    response.email + "</h5></div>"
                var data2 = "<h1 class='text-white'>Selamat Datang, " + response.username +
                    "</h1>";
                $("#datauserkanan").append(data1);
                $("#datauserkiri").append(data2);

            } catch (e) {
                window.location.replace("error_page.php")
            }
        },
        error: function() {
            window.location.replace("error_page.php")
        }
    });
});
</script>

</html>