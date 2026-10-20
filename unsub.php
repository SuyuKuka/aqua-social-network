<?php
    session_start();
    require("fonction.php");
    $conn=conn_start();

    $sub=mysqli_escape_string($conn,$_SESSION['user']);
    $subto=mysqli_real_escape_string($conn,$_POST['subto']);

    $sql = "DELETE FROM subs WHERE user=$sub AND subto=$subto";
    mysqli_query($conn, $sql);

    $subid = $_POST['subto'];

    $sql="SELECT pseudo FROM users WHERE id=$subid";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    
    header("Location: profile.php?u=$row[pseudo]");
    exit;
?>