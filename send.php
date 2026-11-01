<?php
    session_start();
    require('fonction.php');
    $conn = conn_start();
    is_connected();

    $id = mysqli_real_escape_string($conn, $_SESSION['user']);

    $message_htmlspecialchar = htmlspecialchars($_POST['message']);
    $message_nl2br = nl2br($message_htmlspecialchar);
    $message = mysqli_real_escape_string($conn, $message_nl2br);

    //Si l'utilisateur envoie une image
    if(!empty($_FILES["image"]["name"])){
        $tmp = $_FILES["image"]["tmp_name"];
        $imageName = uniqid(). "-" . $_FILES["image"]["name"];
        $size = $_FILES["image"]['size'];
        $type = $_FILES["image"]['type'];
            
        //Taille maxiamale 5Mo
        if($size>5000000){
            echo "L'image est trop grande";
        }
        //Type de fichier
        if($type != "image/jpeg" && $type != "image/png" && $type != "image/jpg" && $type != "image/jfif" ) {
            echo "Seules les images jpeg, png, jpg, jfif sont acceptés";
        }
        
        //Envoie dans le dossier release
        $release = "release/" . $imageName;
        move_uploaded_file($tmp, $release);
    }

    if(isset($_POST['envoyer'])){
        //Cas ou on envoie rien
        if(empty($message) && !isset($release)){
            header('Location: home.php');
            exit;
        } else {
            $user_id = $id = mysqli_real_escape_string($conn, $_SESSION['user']);
            
            if(!isset($release)){
                //Si on envoie juste un message
                $sql = "INSERT INTO `message`(`user_id`, `message`) VALUES ('$id', '$message')";
                mysqli_query($conn, $sql);

                header('Location: profile.php');
                exit;
            }else if(empty($message)){
                //Si on envoie juste une image
                $sql = "INSERT INTO `message`(`user_id`, `image`) VALUES ('$id', '$release')";
                mysqli_query($conn, $sql);

                header('Location: profile.php');
                exit;
            }else{
                //Si on envoie une image avec un message
                $sql = "INSERT INTO `message`(`user_id`, `message`, `image`) 
                        VALUES ('$id', '$message' ,'$release')";
                mysqli_query($conn, $sql);

                header('Location: profile.php');
                exit;
            }
        }
    }
?>
