<?php
    session_start();
    require('fonction.php');
    $conn=conn_start();
    is_connected();
    $id=$_SESSION["user"];
    if(isset($_POST['save'])){
        //Prends les informations de l'utilisateur
        $sql = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $pseudo=$row['pseudo'];
        $email=$row['email'];

        //Récupère les nouvelles informations
        $pseudo_htmlspecialchar = htmlspecialchars($_POST['pseudo']);
        $new_pseudo = mysqli_real_escape_string($conn, $pseudo_htmlspecialchar);
        $email_htmlspecialchar = htmlspecialchars($_POST['email']);
        $new_email = mysqli_real_escape_string($conn, $email_htmlspecialchar);
        $password_htmlspecialchar = htmlspecialchars($_POST['password']);
        $new_password =  mysqli_real_escape_string($conn, $password_htmlspecialchar);

        if(empty($new_pseudo)){
            header('Location: edit_error.php?pseudo');
            exit;
        }

        //Si le pseudo est différent => application des moditifactions sinon rien
        if($pseudo!=$new_pseudo){
            $sql = "SELECT * FROM users WHERE pseudo='$new_pseudo'";
            $result = mysqli_query($conn, $sql);
            //Si le pseudo est déjà pris = erreur sinon ça le change
            if (mysqli_num_rows($result) > 0) {
                header('Location: edit_error.php?pseudo');
                exit;
            }else{
                $set_pseudo = "UPDATE users SET pseudo = '$new_pseudo' WHERE id = '$id'";
                mysqli_query($conn, $set_pseudo);
            }
        }

        //Si l'email est différent => application des moditifactions sinon rien
        if($email!=$new_email){
            $sql = "SELECT * FROM users WHERE email='$new_email'";
            $result = mysqli_query($conn, $sql);
             //Si l'email est déjà pris = erreur sinon ça le change
            if (mysqli_num_rows($result) > 0) {
                header('Location: edit_error.php?email');
                exit;
            }else{
                $set_email = "UPDATE users SET email = '$new_email' WHERE id = '$id'";
                mysqli_query($conn, $set_email);
            }
        }

        //S'il a mit un mot de passe => application des moditifactions sinon rien
        if(isset($new_password)){
            $length = strlen($new_password);
            $majuscule = preg_match('@[A-Z]@', $new_password);
            $minuscule = preg_match('@[a-z]@', $new_password);
            $chiffre = preg_match('@[0-9]@', $new_password);
            //Si il respecte toute les conditions, change le mot de passe sinon erreur
            if($majuscule && $minuscule && $chiffre && $length>=8){
                $password = md5($new_password);
                $set_password = "UPDATE users SET password = '$password' WHERE id = '$id'";
                mysqli_query($conn, $set_password);
            }else{
                header('Location: edit_error.php?condition');
                exit;
            }
        }
        //Retour à l'edition
        header('Location: edit.php');
                exit;
    }
?>