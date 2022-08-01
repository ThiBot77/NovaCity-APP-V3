<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: darkweb_login.php");
    exit;
}
?>



<?php



$bdd = new PDO ('mysql:host=localhost;dbname=novacityapp;charset=utf8;', 'root', 'X@JA64iui**8');
if(isset($_POST['envoyer'])){
    if(!empty($_POST['message'])){
        $username_message = htmlspecialchars($_SESSION["username"]);
        $message = nl2br(htmlspecialchars($_POST['message']));

        $insererMessage = $bdd->prepare('INSERT INTO messages_darkweb(username, message) VALUES(?, ?)'); 
        $insererMessage->execute(array($username_message, $message));
        header("location: darkweb.php");
        exit;

    }else{
        echo "Veuillez compléter les champs ....";
    }



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
    <img src="img/hacker_fond.jpg " class="background-img ">
    <div class="darkweb_div_01">
        <div>
            <div class="darkweb_div_02">
                <div class="darkweb_div_03">
                    <h1 class="my-5">Bonjour, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
                    <h2>Bienvenue sur le site du DarkWeb de Nova City</h1>
                </div>
                <div class="btn_logout_reset_div">
                    <div>
                        <a href="darkweb_reset_password.php" class="btn_logout_reset_01">Réinitialiser votre mot de
                            passe</a>
                    </div>
                    <div>
                        <a href="darkweb_logout.php" class="btn_logout_reset_01">Déconnexion de votre compte</a>
                    </div>
                </div>

            </div>
            <div class="darkweb_div_04">
                <div class="darkweb_div_05">
                    <h2 class>Règlement et Information</h2>
                </div>
                <p>- Le DarkWeb de Nova City est disponible pour tout citoyen,<br> cependant celui-ci est accessible par
                    la
                    police, vous êtes<br> responsables de vos actes et paroles envoyer sur ce site. </p>
                <p>- Il est obligatoire de renseigner votre vrai prénom et nom RP,<br> celui ci ne sera pas visible sur
                    le
                    site,
                    mais il permet au membre<br> de gouvernement de connaitre l'identité de toute personne en cas<br> de
                    problème
                    sur l'utilisation du site</p>
                <p>- Soyez sans crainte le mot de passe renseigner est crypté<br> de notre côté et nous ne pouvons en
                    aucun
                    cas y accéder. </p>
            </div>
        </div>
        <div class="darkweb_chat_div_01">
            <div class="darkweb_chat_div_03">
                <div class="darkweb_chat_div_02">

                    <div>
                        <section id="messages"></section>

                        <script>
                        setInterval('load_messages()', 500);

                        function load_messages() {
                            $('#messages').load('load_messages_darkweb.php')
                        }
                        </script>

                    </div>
                </div>
                <div>
                    <br>
                    <br>
                    <div>
                        <form method="POST" action="">
                            <div class="btn_send_msg_div_01">
                                <div>
                                    <textarea class="textarea_send_msg_01" type="text" name="message"> </textarea>
                                </div>
                                <div>
                                    <input class="btn_send_msg_01" type="submit" name="envoyer" value="Envoyer" />
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>