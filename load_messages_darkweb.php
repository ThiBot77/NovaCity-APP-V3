<link rel="stylesheet" href="style.css" />

<?php
$bdd = new PDO ('mysql:host=localhost;dbname=novacityapp;charset=utf8;', 'root', 'X@JA64iui**8');
$recupMessages = $bdd->query('SELECT * FROM messages_darkweb');
while($message = $recupMessages->fetch()){
    ?>
<div class="message">
    <p lass="message_p"><?= $message['message']; ?></p>
</div>
<?php
}
?>