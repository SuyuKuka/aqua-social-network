<?php
    $conn=conn_start();

    $search=mysqli_real_escape_string($conn, $_GET['search']);

    if($_GET['search']==""){
        header("Location: search.php");
    } else {
     //Recherche: 
     $sql = "SELECT pseudo,id,pfp FROM users WHERE pseudo LIKE '%$search%' OR id LIKE '%$search%'";
     $result=mysqli_query($conn, $sql);
     if(mysqli_num_rows($result)>0){

        //Affichage des résultats: 
        foreach($result as $array){
            echo "<section class=display>";
                echo "<section class=col1>";
                echo "<br><br> <img src=$array[pfp] id='image'> <br>";
                echo "</section>";
                echo "<section class=col2>";
                echo "<a href=profile.php?u=$array[pseudo] class='search-link'> $array[pseudo]  </a> <br>";
                echo "id: $array[id] <br>";
                echo "</section>";
            echo "</section>";
        }
    } else {
        echo "<div class='no-result'>";
        echo "Aucun résultat trouvé";
        echo "</div>";
    }
}
?>