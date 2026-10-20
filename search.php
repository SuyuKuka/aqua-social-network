<?php 
session_start();
require("fonction.php");
is_connected();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Page de recherche</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <nav>
        <?php require_once("nav.php"); ?>
    </nav>
    <div class="search">
        <form action="search.php" method="get">
            <input type="text" name="search" placeholder="Search by pseudo or id..." value=""><br>
        </form>
    </div>

    <br>

    <?php 
        if(isset($_GET['search'])){
            echo "<div class='result'>";
            require_once("search_user.php");
            echo "</div>";
        }
    ?>
</body>
</html>