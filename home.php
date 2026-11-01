<?php
   session_start();
   require("fonction.php");
   //Vérifier que l'utilisateur est connecté:
   is_connected();
   $conn=conn_start();
?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
   <?php require_once("nav.php"); ?>

    <div class="send">
        <form action="send.php" method="post" enctype="multipart/form-data" align="center">
        <br>
        <textarea name="message" rows="20" cols="40" placeholder="Ecrivez votre message ici..."></textarea>
        <br>
        <input type="file" id="send-img" name="image">
        <br><br>
        <input type="submit" name="envoyer">
        </form>
    </div>

    <div class="content">
        <?php  
            //Affichage du fil d'actualité:
            echo "<h1>Fil d'actuailité:</h1>";

            echo "<div class='display'>";
                require_once('home_timeline.php');    
            echo "</div>";
        ?>
    </div>
</body>
</html>