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
        
        //Vérifier que la publication est liké:
        $sql="SELECT liked_post FROM likes WHERE liked_by='$id' AND liked_post='$postID'";
        $liked=mysqli_query($conn,$sql);

        if(mysqli_num_rows($liked)>0){
            if(mysqli_num_rows($result)>0){
                $delete = "DELETE FROM likes WHERE liked_post='$postID' AND liked_by='$id'";
                mysqli_query($conn, $delete);
                header("Location: like_confirm.php?deleted=$_GET[p]");
            } else {
                header("Location: like_confirm.php?nolike=$_GET[p]");
            }
        } else {
            header("Location: unknown_post.php?up");
        }
    } else {
        header("Location: home.php");
    }
?>