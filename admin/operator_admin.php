<?php
include "../connect.php";
session_start();

if (isset($_SESSION["loggedinadmin"]) && $_SESSION["loggedinadmin"] === true && $_SESSION['role'] == 1) {
    $user = $_SESSION["username"];
}else {
    header("location:index.php");
    exit;
}

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id_admin FROM admin WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
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
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO admin (username,password) VALUES (?,?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: operator_admin.php");
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
                echo "<a class='list-group-item list-group-item-action bg-dark our-font' href='user.php'><i class='fas fa-user-circle mr-2'></i>".ucfirst($user)."</a>";
                ?>
                <a href="film.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-film mr-2"></i>Film</a>
                <a href="studio.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-warehouse mr-2"></i>Studio</a>
                <a href="jadwal.php" class="list-group-item list-group-item-action bg-dark our-font"><i
                        class="fas fa-calendar-alt mr-2"></i></i>Jadwal</a>
                <a href="operator_admin.php" class="list-group-item list-group-item-action bg-secondary our-font"><i
                        class="fas fa-users mr-2"></i>Operator</a>
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
                <div class="row p-2 text-center mt-5 ">
                    <div class="col-md-12">
                        <a class="btn btn-info font-weight-bold mr-2" href="#" id="btn_lihat_operator">Lihat
                            Operator</a>
                        <a class="btn btn-success font-weight-bold mr-2" href="#" id="btn_tambah_operator">Tambah
                            Operator</a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-8 tengah animate-bottom" id="lihat_data_operator">
                        <h1 class="mt-4 text-center">Operator</h1>
                        <table class="table text-white mt-5 our-table-hover table-responsive-lg" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th>Id Admin</th>
                                    <th class="align-middle">Username</th>
                                    <th class="align-middle">Role</th>
                                    <th class="align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_user">

                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-8 tengah hide-div animate-bottom" id="tambah_data_operator">
                        <h1 class="mt-4 text-center">Tambah Operator</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="<?php echo $username; ?>">
                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>
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
                            <div class="form-group">
                                <input type="submit" class="btn btn-block w-50 tengah color-obj font-weight-bold"
                                    value="Daftar">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- Bagian Tengah -->
        </div>
</body>

<script src="js/plugin-sort-table/sorttable.js"></script>
<script>
$(document).ready(function() {
    $("table_user").addSortWidget(); //plugin tambahan untuk sort data table 

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function generate_list_admin() {
        $("#table_user").empty()
        $.ajax({
            type: "GET",
            url: 'process/get_admin_user_list.php',
            success: function(response) {
                try {
                    response = $.parseJSON(response);
                    response.forEach(function(data) {
                        if (data['role'] == 1) {
                            var txt1 = "<tr><td class='text-center'>" + data['id_admin'] +
                                "</td><td class='text-center'> " + data[
                                    'username'] +
                                "</td><td class='align-middle text-center'><div class='btn btn-danger btn-block'>Admin</div></td></tr>"
                        } else {
                            var txt1 = "<tr><td class='text-center'>" + data['id_admin'] +
                                "</td><td class='text-center'>" + data['username'] +
                                "</td><td class='align-middle text-center'><div class='btn btn-info btn-block'>Operator</div></td><td class='align-middle text-center'><a class='btn btn-danger' href='process/post_hapus_admin.php?id_admin=" +
                                data['id_admin'] + "'>Hapus</div></td></tr>"
                        }
                        $("#table_user").append(txt1)
                    })
                } catch (e) {}
            },
            error: function() {
                window.location.replace("index.php");
            }
        });
    }
    generate_list_admin();

    $("#btn_tambah_operator").click(function(e) {
        e.preventDefault();
        $("#lihat_data_operator").addClass("hide-div");
        $("#tambah_data_operator").removeClass("hide-div");
    });

    $("#btn_lihat_operator").click(function(e) {
        e.preventDefault();
        $("#lihat_data_operator").removeClass("hide-div");
        $("#tambah_data_operator").addClass("hide-div");
    });
});
</script>


</html>