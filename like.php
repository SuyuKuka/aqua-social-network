<?php
    session_start();
    require("fonction.php");
    $conn=conn_start();

    //Vérifier que le get est présent:
    if(isset($_GET['p'])){
        $postID=mysqli_real_escape_string($conn,$_GET['p']);
        $id=mysqli_real_escape_string($conn,$_SESSION['user']);

        //Vérifier que la publication existe:
        $sql="SELECT id FROM message WHERE id='$postID'";
        $result=mysqli_query($conn,$sql);

        //Vérifier que la publication n'a pas déjà été liké:
        $sql="SELECT liked_post FROM likes WHERE liked_by='$id' AND liked_post='$postID'";
        $liked=mysqli_query($conn,$sql);

        if(mysqli_num_rows($liked)>0){
            header("Location: like_confirm.php?liked=$_GET[p]");
        } else {
            if(mysqli_num_rows($result)>0){
                $insert = "INSERT INTO likes(liked_post, liked_by) 
                VALUES ('$postID','$id')";
                mysqli_query($conn, $insert);
                header("Location: like_confirm.php?like=$_GET[p]");
            } else {
                header("Location: unknown_post.php?up");
            }
        }
    } else {
        header("Location: home.php");
    }
?>