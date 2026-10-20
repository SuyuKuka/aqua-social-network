<?php
    if(isset($_POST['back'])){
        header('Location: profile.php');
        exit;
    }
    if(isset($_POST['save'])){
        session_start();
        require('fonction.php');
        $conn=conn_start();
        is_connected();

        $verif=false;
        $id=$_SESSION["user"];
        
        
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $verif=false;
        $pseudo=$row['pseudo'];
        $new_pseudo= mysqli_real_escape_string($conn, $_POST['pseudo']);
        $email=$row['email'];
        $new_email = mysqli_real_escape_string($conn, $_POST['email']);

        $new_password = $_POST['password'];
        
        
        echo $pseudo;
        echo "<br>";
        echo $new_pseudo;
        echo "<br>";
        if($pseudo!=$new_pseudo){
            $sql = "SELECT * FROM users WHERE pseudo='$new_pseudo'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                header('Location: edit_error.php?pseudo');
                exit;
            }else{
                $set_pseudo = "UPDATE users SET pseudo = '$new_pseudo' WHERE id = '$id'";
                mysqli_query($conn, $set_pseudo);
            }
        }

        if($email!=$new_email){
            $sql = "SELECT * FROM users WHERE email='$new_email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                header('Location: edit_error.php?email');
                exit;
                
            }else{
                $set_email = "UPDATE users SET email = '$new_email' WHERE id = '$id'";
                mysqli_query($conn, $set_email);
            }
        }

        if(!isset($new_password)){
            $length = strlen($new_password);
            $majuscule = preg_match('@[A-Z]@', $new_password);
            $minuscule = preg_match('@[a-z]@', $new_password);
            $chiffre = preg_match('@[0-9]@', $new_password);
            if($majuscule && $minuscule && $chiffre && $length<8){
                $set_password = "UPDATE users SET 'password' = '$new_password' WHERE id = '$id'";
                mysqli_query($conn, $set_password);
            }else{
                header('Location: edit_error.php?condition');
                exit;
            }
        }

        header('Location: profile.php');
        exit;
    }
?>