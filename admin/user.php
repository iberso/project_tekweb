<?php
include "security_check_admin.php";
include "../connect.php";
// session_start();

$id_admin = $_SESSION["id_admin"];
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
        $sqlupdate = "UPDATE admin SET password = ? WHERE id_admin= ?";
        if($stmt = mysqli_prepare($link, $sqlupdate)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_id);
            
            // Set parameters
            $param_id = $_SESSION["id_admin"];
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // $_SESSION["loggedinadmin"] = false;
                header("location: logout_admin.php");
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
    <title>OUR CINEMA21 [ADMIN DASHBOARD]</title>
    <link rel="icon" href="../img/XXI.ico">
    <!--BOOTSTRAPS-->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/our-cinema-style.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_css.css">
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
.card {
    transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
    cursor: pointer;
}

.card:hover {
    transform: scale(1.05);
}
</style>

<body class="color-back">
    <div class="d-flex" id="wrapper">
        <!-- Awal Sidebar -->
        <div class="bg-dark border-right border-dark" id="sidebar-wrapper">
            <div class="sidebar-heading our-font text-center"><i class="fas fa-user-cog mr-2 "></i>Dashboard
                Admin
            </div>
            <div class="list-group list-group-flush" style="font-size:13pt;">
                <?php 
                echo "<a class='list-group-item list-group-item-action bg-secondary our-font' href='user.php'><i class='fas fa-user-circle mr-2'></i>".ucfirst($user)."</a>";
                ?>
                <a href="film.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-film mr-2"></i>Film</a>
                <a href="studio.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-warehouse mr-2"></i>Studio</a>
                <a href="jadwal.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-calendar-alt mr-2"></i></i>Jadwal</a>
                <?php if($_SESSION['role'] == 1){ 
                    echo "<a href='operator_admin.php' class='list-group-item list-group-item-action bg-dark our-font'><i class='fas fa-users mr-2'></i class>Operator</a>";
                    } 
                ?>
                <a class="list-group-item list-group-item-action bg-dark our-font" href="logout_admin.php"><i
                        class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </div>
        </div>
        <!-- Akhir Sidebar -->

        <!-- Bagian Tengah -->
        <div id="page-content-wrapper">
            <!-- Awal Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top shadow-sm">
                <button class="btn color-obj" id="menu-toggle"><i class="fas fa-bars text-white"></i></button>

                <ul class="navbar-nav tengah" style="font-size:13pt;">
                    <div class="navbar-text">
                        <img src="../img/Our_Cinema_XXI.png" width="280" height="35" alt="logo cinemax">
                    </div>
                </ul>

            </nav>
            <!-- Akhir Navbar -->

            <div class="container-fluid text-white mt-5">

                <div class="row">
                    <div class="col-md-4 text-center ">
                        <div class="bg-dark our-border">
                            <img src='../img/admin.png' width='250px' height='250px' class='tengah'>
                            <h5 class="p-3">Selamat Datang, <?php echo $_SESSION['username'] ?></h5>
                        </div>
                    </div>
                    <div class="col-md-8 bg-dark our-border">

                        <h4 class="mt-3">Reset Password</h4>
                        <form method="POST">
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control"
                                    value="<?php echo $password; ?>">
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
                </p>
            </div>
        </div>
        <!-- Bagian Tengah -->
    </div>
</body>



<!--AWAL SCRIPT-->
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
<!--AKHIR SCRIPT-->

</html>