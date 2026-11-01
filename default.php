<?php
    session_start();
    require('fonction.php');
    $conn=conn_start();

    is_connected();
    $id = mysqli_real_escape_string($conn,$_SESSION['user']);

    //Si sa pfp est différente de celle de base, on supprime l'image 
    //existante dans le dossier pour mettre la nouvelle
    //afin d'eviter que le dossier soit trop lourd
    $replace_sql = "SELECT pfp FROM users WHERE id='$id'";
    $replace_result = mysqli_query($conn, $replace_sql);
    $replace_row = mysqli_fetch_assoc($replace_result);
    if($replace_row['pfp']!="uploads/default.png"){
      unlink($replace_row['pfp']);
    }

    $default = "UPDATE users SET pfp = 'uploads/default.png' WHERE id = '$id'";
    mysqli_query($conn, $default);

    header('Location: edit.php');
    exit;
?>