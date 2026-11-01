<?php
    session_start();
    require("fonction.php");

    echo "<nav>";
        require_once('nav.php');
    echo "</nav>" ;

    //En fonction de ce qu'il reçoit il va soit liker, deliker etc
    if(isset($_GET['liked'])){
        header("Location: post_details.php?p=$_GET[liked]");
        exit;
    } else if (isset($_GET['like'])){
        header("Location: post_details.php?p=$_GET[like]");
        exit;
    } else if(isset($_GET['deleted'])) {
        header("Location: post_details.php?p=$_GET[deleted]");
        exit;
    } else if(isset($_GET['nolike'])) {
        header("Location: post_details.php?p=$_GET[nolike]");
        exit;
    } else {
        header("Location: home.php");
    }
?>