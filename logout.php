<?php
    session_start();
    require('fonction.php');
    $conn=conn_start();
    is_connected();

    //Deconnection
    session_destroy();
    header('Location: login.php');
?>