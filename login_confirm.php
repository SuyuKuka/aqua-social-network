<?php 
    //Connection aux serveurs
    session_start();
    require('fonction.php');
    $conn=conn_start();

    //Récupère les informations de login
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_check = md5($password);

    //Regarde si le password correspond à l'email entrée
    $sql = "SELECT password FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $nums = mysqli_num_rows($result);
    echo $nums;

    if ($nums > 0){
        $row = mysqli_fetch_assoc($result);
        if ($password_check==$row['password']){
            $sql = "SELECT id FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user']=$row['id'];

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