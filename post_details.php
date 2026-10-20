<?php
session_start();
require("fonction.php");
is_connected();
$conn=conn_start();

echo "<nav>";
require_once('nav.php');
echo "</nav>" ;
?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Détails de la publication:</title>
    <link rel="stylesheet" href="post-details.css">
</head>
<body>
    <?php
    if(isset($_GET['p'])){
        $postID=mysqli_real_escape_string($conn,$_GET['p']);
        $id=mysqli_real_escape_string($conn,$_SESSION['user']);

        $sql="SELECT m.id,m.user_id,m.timestamp,m.message,m.image,u.pseudo,u.pfp 
        FROM message AS m, users AS u 
        WHERE m.id='$postID' AND m.user_id=u.id";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            echo "<div class='display'>";
            $row=mysqli_fetch_assoc($result);
            //Affichage des informations liées à l'auteur des publications
            echo "<div class='message'>";
                echo "<section class='info'>";
                
                    echo "<section class='pfp'>";
                        echo "<img src='$row[pfp]' id='pfp'> <br>";
                    echo "</section>";

                    echo "<section class='user'>";
                        echo "<label for='profile-pseudo'>$row[pseudo]</label><br>";
                        echo "<label for='profile-id'>id: $row[user_id] </label><br>";
                        echo "<label for='profile-time'>$row[timestamp] </label><br>";
                    

                        //Vérification du type de contenu:
                        echo "<div class='separe'>";
                            if(!empty($row['message'])){
                                echo "$row[message] <br>";
                            }
                            if(!empty($row['image'])){
                                echo "<img src='$row[image]' id='post-image'> <br>"; 
                            }
                        echo "</div>";
                    echo "</section>";
                echo "</section>";
            echo "</div>";

            echo "<div class='like-comment'>";
                //Afficher le nombre de likes:
                $sql="SELECT COUNT(liked_post) FROM likes WHERE liked_post='$postID'";
                $liked=mysqli_query($conn,$sql);
                $count=mysqli_fetch_assoc($liked);
                echo "Likes: ".$count['COUNT(liked_post)']."<br>";

                //Afficher la fonction pour liker ou retirer un like:
                if($row['user_id']!=$_SESSION['user']){
                    $id=mysqli_real_escape_string($conn,$_SESSION['user']);
                    $sql="SELECT liked_post FROM likes WHERE liked_by='$id' AND liked_post='$postID'";
                    $liked=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($liked)>0){
                        echo"<a href='like_remove.php?p=$_GET[p]'> Retirer le like </a>";
                    } else {
                        echo"<a href='like.php?p=$_GET[p]'> Like </a>";
                    }
                }

                $delete_sql = "SELECT user_id,id FROM message WHERE id=$postID";
                $delete_result = mysqli_query($conn, $delete_sql);
                $delete_row = mysqli_fetch_assoc($delete_result);
                if($_SESSION['user']==$delete_row['user_id'] || isAdmin($_SESSION['user'])){
                    $pseudo_sql = "SELECT pseudo FROM users WHERE id=$_SESSION[user]";
                    $pseudo_result = mysqli_query($conn, $pseudo_sql);
                    $pseudo_row = mysqli_fetch_assoc($pseudo_result);
                    echo "<form method='post' action='delete_message.php' id='delete-publication'>";
                    echo "<input type='hidden' name='message_id' value='" . $delete_row['id'] . "'>";
                    echo "<input type='hidden' name='pseudo' value='" . $pseudo_row['pseudo'] . "'>";
                    echo "<input type='submit' value='Supprimer cette publication' name='delete' id='button-form'>";
                    echo "</form><br>";
                }
            echo "</div>";

            //Ajouter un commentaire:
            echo "<form action=comment.php method=post id='add-comment'>";
            echo "<input type=hidden id=message name=message value=$postID>";
            echo "<input type=submit value='Ajouter un commentaire' id='button-form'>";
            echo "</form>";
            

            //Afficher les commenatires:
            $sql="SELECT comments.*,users.pseudo,users.pfp FROM comments,users WHERE message_id='$postID' AND users.id=author";
            $comments=mysqli_query($conn,$sql);
            if(mysqli_num_rows($comments)>0){
                foreach($comments as $array){
                    echo "<div class='message'>";
                        echo "<section class='info'>";
                            echo "<section class='pfp'>";
                                echo "<img src='$array[pfp]' id='pfp'> <br>";
                            echo "</section>";

                            echo "<section class='user'>";
                                echo "<label for='profile-pseudo'>$array[pseudo]</label><br>";
                                echo "<label for='profile-id'>id: $array[author]</label><br>";
                                echo "<label for='profile-time'>$row[timestamp] </label><br><br>";
                                echo "$array[comment] <br>";
                            echo "</section>";
                        echo "</section>";
                    echo "</div>";

                echo "<div class='like-comment'>";
                //Afficher la possibilité de supprimer le commentaire si il s'agit de l'auteur ou d'un admin:
                    if($_SESSION['user']==$array['author'] || isAdmin($_SESSION['user'])){
                        echo "<form action=comment_delete.php method=post id='delete'>";
                        echo "<input type=hidden id=author name=author value=$array[author]>";
                        echo "<input type=hidden id=message name=message value=$postID>";
                        echo "<input type=hidden id=commentID name=commentID value=$array[id]>";
                        echo "<input type=submit value='Supprimer le commentaire' id='button-form'>";
                        echo "</form>";
                    }   
                echo "</div>";
                }
            } else {
                echo "<div class='no-result'>";
                echo "Aucun commentaire";
                echo "</div>";
            }
        } else {
            header("Location: unknown_post.php?up");
        }
    } else {
        header("Location: home.php");
    }
?>
</div>
</body>
</html>