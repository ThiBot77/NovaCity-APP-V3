<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: lebonplan.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$rpname = $password = "";
$rpname_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if rpname is empty
    if(empty(trim($_POST["rpname"]))){
        $rpname_err = "Please enter rpname.";
    } else{
        $rpname = trim($_POST["rpname"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($rpname_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, rpname, password FROM users_lebonplan WHERE rpname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rpname);
            
            // Set parameters
            $param_rpname = $rpname;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if rpname exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $rpname, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["rpname"] = $rpname;                            
                            
                            // Redirect user to welcome page
                            header("location: lebonplan.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Nom RP ou mot de passe invalide.";
                        }
                    }
                } else{
                    // rpname doesn't exist, display a generic error message
                    $login_err = "Nom RP ou mot de passe invalide.";
                }
            } else{
                echo "Oups ! Un probl??me est survenu. Veuillez r??essayer plus tard.";
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>


<header>

    <TITLE>Nova City</TITLE>
    <link rel="shortcut icon" href="img/logo_nova_city.png" type="image/x-icon">

    <nav>


        <div class="nav_barre">

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
    <img src="img/lebonplan_fond.jpg" class="background-img ">

    <div class="lebonplan_login_div_01">
        <div class="lebonplan_login_div_02">
            <div class="lebonplan_login_div_03">
                <h2>Connexion</h2>
                <p>Veuillez remplir vos informations d'identification pour vous connecter sur LeBonPlan
                </p>
            </div>

            <div>



                <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <div>
                            <div>
                                <label>Nom d'utilisateur</label>
                                <input type="text" name="rpname" class="w3-input w3-border w3-round-large"
                                    <?php echo (!empty($rpname_err)) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $rpname; ?>">
                                <span class="lebonplan_login_error_01"><?php echo $rpname_err; ?></span>
                            </div>
                            <div>
                                <label>Mot de passe</label>
                                <input type="password" name="password" class="w3-input w3-border w3-round-large"
                                    <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="lebonplan_login_error_01"><?php echo $password_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="lebonplan_login_div_04">
                        <div>
                            <input type="submit" class="btn_registration_01" value="Connexion">
                        </div>
                        <p>Vous n'avez pas de compte ? </p>
                        <a class="link_lebonplan" href="lebonplan_registration.php">Inscrivez-vous
                            maintenant</a>
                    </div>

                </form>
            </div>
        </div>

    </div>

</html>