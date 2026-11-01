<?php
    $conn=conn_start();
    $id=mysqli_real_escape_string($conn,$_SESSION['user']);

    //Regarde si l'uitlisateur est abonné ou non
    $abonnements = "SELECT * FROM subs WHERE user=$id";
    $result_abonnements = mysqli_query($conn, $abonnements);
    $nb_abonnements = mysqli_num_rows($result_abonnements);

    //S'il est abonné à quelqu'un ça prends ces messages et aussi ses messages
    //Sinon ça ne prends que ses messages
    if($nb_abonnements>0){
        $sql="SELECT s.subto,u.pseudo,u.pfp,m.message,m.user_id,m.timestamp,m.message,m.image,m.id
        FROM subs AS s, users AS u, message AS m 
        WHERE s.user='$id' AND u.id=s.subto AND m.user_id=s.subto
        ORDER BY m.id DESC";
        $result=mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0){
            foreach($result as $array){
                //Affichage des informations liées à l'auteur des publications
                echo "<div class='message'>";
                    echo "<section class='info'>";

                        echo "<section class='pfp'>";
                            echo "<img src='$array[pfp]' id='pfp'> <br>";
                        echo "</section>";

                        echo "<section class='user'>";
                            echo "<label for='profile-pseudo'>$array[pseudo]</label> <br>";
                            echo "<label for='profile-id'>id: $array[user_id]</label> <br>";
                            echo "<label for='profile-time'>$array[timestamp]</label> <br>";

                            echo "<div class='separe'>";
                                echo "$array[message] <br>";
                                if(!empty($array['image'])) {
                                    echo "<img src='$array[image]' id='post-image'>"; 
                                }
                            echo "</div>";
                        echo "</section>";
                        
                    echo "</section>";
                    
                    echo "<a href='post_details.php?p=$array[id]' id='details'> Détails de la publication  </a>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-message'>Aucune publication</p>";
        }
    }else{
            echo "<p class='no-message'>Aucun abonnement</p>";
    }
?>