<?php
    session_start();
    require('fonction.php');
    $conn=conn_start();
    is_connected();

    session_destroy();
    header('Location: login.php');
?>