<?php 
    //Connection aux serveurs
    session_start();
    require('fonction.php');
    $conn=conn_start();

    //Récupère les informations de login
    $email_htmlspecialchar = htmlspecialchars($_POST['email']);
    $email = mysqli_real_escape_string($conn, $email_htmlspecialchar);
    $password_htmlspecialchar = htmlspecialchars($_POST['password']);
    $password =  mysqli_real_escape_string($conn, $password_htmlspecialchar);
    $password_check = md5($password);

    //Regarde si le password correspond à l'email entrée
    $sql = "SELECT password FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $nums = mysqli_num_rows($result);
    if ($nums > 0){
        $row = mysqli_fetch_assoc($result);
        //Vérifie si le mot de passe est correct
        if ($password_check==$row['password']){
            $sql = "SELECT id FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user']=$row['id'];
            //Connecté
            header('Location: home.php');
            exit;
        }else{
            header('Location: login_error.php?password');
            exit;
        }
    } else {
        header('Location: login_error.php?email');
        exit;
    }
?>