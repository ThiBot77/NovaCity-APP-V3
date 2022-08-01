<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$rpname = $password = $confirm_password = "";
$rpname_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate rpname
    if(empty(trim($_POST["rpname"]))){
        $rpname_err = "Veuillez entrer un nom d'utilisateur.";
    }  else{
        // Prepare a select statement
        $sql = "SELECT id FROM users_lebonplan WHERE rpname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rpname);
            
            // Set parameters
            $param_rpname = trim($_POST["rpname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $rpname_err = "Ce nom d'utilisateur est déjà pris.";
                } else{
                    $rpname = trim($_POST["rpname"]);
                }
            } else{
                echo "Oups ! Un problème est survenu. Veuillez réessayer plus tard.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer un mot de passe.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Le mot de passe doit comporter au moins 6 caractères.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Veuillez confirmer le mot de passe.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Le mot de passe ne correspond pas.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($rpname_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users_lebonplan (rpname, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_rpname, $param_password);
            
            // Set parameters
            $param_rpname = $rpname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: lebonplan_login.php");
            } else{
                echo "Oups ! Un problème est survenu. Veuillez réessayer plus tard.";
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

    <img src="img/lebonplan_fond.jpg" class="background-img ">

    <div class="lebonplan_registration_div_01">


    


        <div class="lebonplan_registration_div_03">
            <div>
                <div class="title_form_login">
                    <h2>S'inscrire</h2>
                    <p>Veuillez remplir ce formulaire pour créer un compte sur LeBonPlan</p>
                </div>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="lebonplan_registration_div_04">
                        <div>
                            <div>
                                <label>Nom et Prénom RP</label>
                                <input type="text" name="rpname" class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_registration_error_01"><?php echo $rpname_err; ?></span>

                            </div>
                            <div>
                                <label>Mot de passe</label>
                                <input type="password" name="password" class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_registration_error_01"><?php echo $password_err; ?></span>

                            </div>
                            <div>
                                <label>Confirmation du mot de passe</label>
                                <input type="password" name="confirm_password"
                                    class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_registration_error_01"><?php echo $confirm_password_err; ?></span>

                            </div>
                        </div>
                    </div>
                  <br>
                  
                    <div class="lebonplan_registration_div_06">
                        <div>
                            <input type="submit" class="btn_registration_01" value="Valider">
                        </div>
                        <div>
                            <div>
                                <p>Vous avez déjà un compte ?</p>
                                <a class="link_lebonplan" href="lebonplan_login.php">Connectez-vous ici</a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>

    </div>
</BODY>

</html>