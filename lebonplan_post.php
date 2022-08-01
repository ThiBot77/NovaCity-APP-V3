<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: lebonplan_login.php");
    exit;
}

  

?>


<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$type = $titre = $description = $prix = "";
$type_err = $titre_err = $description_err = $prix_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate type
    if(empty(trim($_POST["type"]))){
        $type_err = "Veuillez choisir votre catégorie d'annonce";     
    } else{
        $type = trim($_POST["type"]);
    }

    // Validate titre
    if(empty(trim($_POST["titre"]))){
        $titre_err = "Veuillez remplir le titre de l'annonce";     
    } else{
        $titre = trim($_POST["titre"]);
    }
    
    // Validate description
    if(empty(trim($_POST["description"]))){
        $description_err = "Veuillez remplir la description de l'annonce";     
    } else{
        $description = trim($_POST["description"]);
    }

     // Validate description
     if(empty(trim($_POST["prix"]))){
        $prix_err = "Veuillez remplir le prix de l'annonce";     
    } else{
        $prix = trim($_POST["prix"]);
    }

     // Validate picture
     if(empty(trim($_POST["post_picture"]))){
        $post_picture = "https://frenchvadrouilleur.fr/data/images/aucun.jpg";   
    } else{
        $post_picture = trim($_POST["post_picture"]);
    }

     // Validate description
     if(empty(trim($_POST["phone_number"]))){
        $phone_number_err = "Veuillez remplir le numéro de téléphone du vendeur";     
    } else{
        $phone_number = trim($_POST["phone_number"]);
    }

    if(empty($type_err) && empty($titre_err) && empty($description_err) && empty($prix_err) && empty($phone_number_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO annonces_lebonplan (username, type, titre, description, prix, phone_number, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss",$param_user, $param_type, $param_titre, $param_description, $param_prix, $param_phone_number, $param_picture);
            
            // Set parameters
            $param_user = htmlspecialchars($_SESSION["rpname"]);
            $param_type = htmlspecialchars($type);
            $param_titre = htmlspecialchars($titre);
            $param_description = htmlspecialchars($description);
            $param_prix = htmlspecialchars($prix);
            $param_phone_number = htmlspecialchars($phone_number);
            $param_picture = htmlspecialchars($post_picture);

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: lebonplan.php");
            } else{
                echo "Oups ! Un problème est survenu. Veuillez réessayer plus tard. ";

            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

}
    
    // Close connection
    mysqli_close($link);

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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

<body onload="startTime()">
    <img src="img/lebonplan_fond.jpg" class="background-img ">
    <div class="lebonplan_post_div_01">

        <div class="lebonplan_post_div_05">
            <h2>Règlement et Information</h2>
            <p>- Le site lebonplan répond aux même règles que la ville concernant les arnaques, merci de vous
                rediriger sur le site de la ville pour en prendre connaissance.</p>
            <p>- Les annonces en doublon sont interdites
                sur le site</p>
            <p>- Les prix de vos articles doivent être réaliste, et non surestimés.</p>
            <p>- Vous pouvez ajouter une image via une URL, si vous ne savez pas comment faire, vous redirigez sur notre discord.  </p>
            <p>- Si vous n'avez pas d'image, laisser le champ vide.</p>
            <p>- Pour toute vente de voitures, merci d'envoyer une image du véhicule dans Nova Life.</p>
        </div>

        <div class="lebonplan_post_div_02">
            <div class="lebonplan_post_div_03">
                <h2>Déposer une annonce</h2>
                <p>Veuillez remplir le formulaire complètement afin de déposer une annonce.
                </p>
            </div>

            <div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <div>
                            <div>
                                <label>Type d'annonce</label>
                                <select name="type" class="w3-input w3-border w3-round-large">
                                    <option value="Immobilière">Immobilière</option>
                                    <option value="Véhicule">Véhicule</option>
                                    <option value="Objet">Objet</option>
                                    <option value="Service">Service</option>
                                    <span class="lebonplan_post_error_01"><?php echo $type_err; ?></span>
                                </select>

                            </div>
                            <div>
                                <label>Titre de l'annonce</label>
                                <input type="text" name="titre" class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_post_error_01"><?php echo $titre_err; ?></span>
                            </div>
                            <div>
                                <label>Description</label>
                                <input type="text" name="description" class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_post_error_01"><?php echo $description_err; ?></span>
                            </div>
                            <div>
                                <label>Prix</label>
                                <input type="text" name="prix" class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_post_error_01"><?php echo $prix_err; ?></span>
                            </div>
                            <div>
                                <label>Photo (Lien URL)</label>
                                <input type="text" name="post_picture" class="w3-input w3-border w3-round-large">
                            </div>
                            <div>
                                <label>Numéro de téléphone du vendeur</label>
                                <input type="text" name="phone_number" class="w3-input w3-border w3-round-large">
                                <span class="lebonplan_post_error_01"><?php echo $phone_number_err; ?></span>
                            </div>

                        </div>
                    </div>

                    <div class="lebonplan_post_div_04">
                        <div>
                            <input type="submit" class="btn_registration_01" value="Valider">
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>