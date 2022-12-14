<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: lebonplan_login.php");
    exit;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
    <div class="lebonplan_div_01">
        <div class="lebonplan_div_02">
            <div>
                <h1 class="my-5">Bonjour, <b><?php echo htmlspecialchars($_SESSION["rpname"]); ?></b></h1>
                <h2>Bienvenue sur le site lebonplan de Nova City</h1>
            </div>
            <div class="btn_logout_reset_div">
                <div>
                    <a href="lebonplan_reset_password.php" class="btn_logout_reset_01">R??initialiser votre mot de
                        passe</a>
                </div>
                <div>
                    <a href="lebonplan_logout.php" class="btn_logout_reset_01">D??connexion de votre compte</a>
                </div>
                <div>
                    <a href="lebonplan_post.php" class="btn_logout_reset_01">Poster une annonce de vente</a>
                </div>
            </div>
        </div>


    </div>

    <div class="post_lebonplan_div_main">

        <?php
		$mysqli = new mysqli("localhost", "root", "X@JA64iui**8", "novacityapp");
		$mysqli->set_charset("utf8");
		$requete = "SELECT * FROM annonces_lebonplan";
		$resultat = $mysqli->query($requete);
		
        ?>

        <div class="post_lebonplan_div_01">

            <?php while ($ligne = $resultat->fetch_assoc()) {

			echo '<div class="post_lebonplan_div_02"> Titre de la vente : ' .$ligne['titre'] . '<br><br> ' . 'Cat??gorie : ' .$ligne['type'] . '<br><br> <img class="lebonplan_img_01" src="'.$ligne['photo'].'" /><br><br> ' .  'Description : ' . $ligne['description'] . '<br><br> ' . 'Prix de vente : ' . $ligne['prix'] . '<br><br> ' . 'Nom du vendeur : ' . $ligne['username'] . '<br><br> ' . 'Num??ro du vendeur : ' . $ligne['phone_number']  . '</div>';

		}
		$mysqli->close();
            ?>
        </div>';





    </div>


</body>

</html>