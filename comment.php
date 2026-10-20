<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Commentaire</title>
    <link rel="stylesheet" href="comment.css">
</head>
<body>
<?php
    session_start();
    require("fonction.php");
    $conn=conn_start();

    if(isset($_POST['message'])){
        echo "<form action=comment_process.php method=post>";
        echo "<h1>Ajoutez votre commentaire: </h1>";
        echo "<input type=hidden id=message name=message value='$_POST[message]'>";
        echo "<textarea name=comment></textarea> <br><br>";
        echo "<input type=submit value='Envoyer'> <br>";
        echo "</form>";
    } else {
        header("Location: home.php");
    }
?>
</body>
</html>