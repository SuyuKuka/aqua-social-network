<?php
    session_start();
    require("fonction.php");
    $conn=conn_start();

    //Offre la possibilité de supprimer le commentaire s'il est auteur du message
    if(isset($_POST['message']) && isset($_POST['commentID']) && isset($_POST['author'])){
        $author=mysqli_escape_string($conn,$_POST['author']);
        $commentID=mysqli_real_escape_string($conn,$_POST['commentID']);

        $sql = "DELETE FROM comments WHERE author='$author' AND id='$commentID'";
        mysqli_query($conn, $sql);

        header("Location: post_details.php?p=$_POST[message]");
    } else {    
        header("Location: home.php");
    }
?>