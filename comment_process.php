<?php
session_start();
require("fonction.php");
$conn=conn_start();

if(isset($_POST['message']) && !empty($_POST['comment'])){
    $id=mysqli_real_escape_string($conn,$_SESSION['user']);
    $comment=htmlspecialchars($_POST['comment']);
    $comment=nl2br($_POST['comment']);
    $comment=mysqli_real_escape_string($conn,$comment);
    $messageID=mysqli_real_escape_string($conn,$_POST['message']);

    $sql="INSERT INTO comments (message_id,comment,author)
    VALUES('$messageID','$comment','$id')";
    mysqli_query($conn,$sql);
    
    header("Location: post_details.php?p=$_POST[message]");
}else{
    header("Location: post_details.php?p=$_POST[message]");
}
?>