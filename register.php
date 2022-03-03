<?php
// Include config file
require_once "connect.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$firstname =  "";
$lastname ="";
$email = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id_user FROM user WHERE username = ?";
        
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
    
    if(!empty(trim($_POST["firstname"]))){    
        $firstname = trim($_POST["firstname"]);
    }
    
    if(!empty(trim($_POST["lastname"]))){    
        $lastname = trim($_POST["lastname"]);
    }
    if(!empty($_POST["email"])){    
        $email= trim($_POST["email"]);
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (firstname,lastname,email,username, password) VALUES (?, ?,?,?,?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_firstname,$param_lastname,$param_email, $param_username, $param_password);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    <title>OUR CINEMA21 [REGISTER]</title>
    <link rel="icon" href="img/XXI.ico">
    <!--BOOTSTRAPS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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

<style>
.tengah {
    margin-left: auto;
    margin-right: auto;
}

.lin {
    color: inherit;
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
                <img src="img/Our_Cinema_XXI.png" width="300" height="40" alt="logo cinemax">
            </a>
        </div>
    </nav>
    <!--AKHIR NAVBAR-->

    <div class="container" style="margin-top:100px;">
        <div class="row text-white">
            <div
                class="col-10 col-sm-10 col-md-7 col-lg-6 shadow card-color-setting tengah p-4 rounded-lg our-color text-white">
                <h2 class="text-center">Sign Up</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" name="firstname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" name="lastname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
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
                    <div class="form-group">
                        <input type="submit" class="btn btn-block w-50 tengah color-obj font-weight-bold"
                            value="Daftar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <h4 class="text-muted text-center" style="margin-top:120px;"> Find us on</h4>
    <h3 class="text-muted text-center">

        <a href="https://www.instagram.com/cinema.21/?hl=id" target="_blank" class=" lin"><i
                class="fab fa-instagram p-1 "></i></a>
        <a href="https://www.facebook.com/CinemaXXI/" target="_blank" class="lin"><i
                class="fab fa-facebook-square p-1"></i></a>
        <a href="https://twitter.com/cinema21" target="_blank" class="lin"><i class="fab fa-twitter p-1"></i></i></a>
        <a href="https://www.youtube.com/user/KanalXXI/videos" target="_blank" class="lin"> <i
                class="fab fa-youtube p-1"></i></a>
    </h3>
</body>

</html>