<?php
    session_start();
    require("fonction.php");
    require_once('nav.php');
?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Unknown</title>
    <link rel="stylesheet" href="unkown.css">
</head>
<body>
    <?php
        if(isset($_GET['up'])){
            echo "<p><h2> Erreur: Publication inconnue. </h2></p>";
        } else {
            header("Location: home.php");
            exit;
        }
    ?>
</body>
</html>