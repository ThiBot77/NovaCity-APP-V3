<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: lebonplan_login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users_lebonplan SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: lebonplan_login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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

    <!DOCTYPE html>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>


<header>

    <TITLE>Nova City</TITLE>
    <link rel="shortcut icon" href="img/logo_nova_city.png" type="image/x-icon">

    <nav>


        <div class="nav_barre ">

            <div>
                <a href="index.html">
                    <img class="icone_nav_home" src="img/home.png ">
                </a>
            </div>
            <div>
                <img class="icone_nav_bluetooth " src="img/Bluetooth.png ">
            </div>
            <div>
                <img class="icone_nav_wifi " src="img/wifi.png ">
            </div>
            <div>
                <img class="icone_nav_batterie " src="img/batterie.png ">
            </div>
            <div id="time_live">

                <script>
                function startTime() {
                    const today = new Date();
                    let h = today.getHours();
                    let m = today.getMinutes();
                    m = checkTime(m);

                    document.getElementById('time_live').innerHTML = h + ":" + m;
                    setTimeout(startTime, 1000);
                }

                function checkTime(i) {
                    if (i < 10) {
                        i = "0" + i
                    }; // add zero in front of numbers < 10
                    return i;
                }
                </script>

            </div>
            <div id="date_live">


                <script>
                n = new Date();
                y = n.getFullYear();
                m = n.getMonth() + 1;
                d = n.getDate();
                document.getElementById("date_live").innerHTML = d + "/" + m + "/" + y;
                </script>
            </div>



        </div>
    </nav>


</header>

<BODY onload="startTime()">

    <img src="img/hacker_fond.jpg " class="background-img ">
    <div class="registration_lebonplan">

        <div class="wrapper">
            <h2>Réinitialiser le mot de passe</h2>
            <p>Veuillez remplir ce formulaire pour réinitialiser votre mot de passe.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="new_password"
                        class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password"
                        class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="btn_logout_reset_div ">
                    <input type="submit" class="btn_logout_reset" value="Valider">
                    <a class="btn_logout_reset" href="lebonplan.php">Annuler</a>
                </div>
            </form>
        </div>

    </div>

</html>