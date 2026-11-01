<?php 
  //Connection aux serveurs
  require('fonction.php');
  $conn=conn_start();

  //Récupère les informations de register
  $pseudo_htmlspecialchar = htmlspecialchars($_POST['pseudo']);
  $pseudo = mysqli_real_escape_string($conn, $pseudo_htmlspecialchar);
  $email_htmlspecialchar = htmlspecialchars($_POST['email']);
  $email = mysqli_real_escape_string($conn, $email_htmlspecialchar);
  $password_htmlspecialchar = htmlspecialchars($_POST['password']);
  $password =  mysqli_real_escape_string($conn, $password_htmlspecialchar);
  $password_confirm_htmlspecialchar = htmlspecialchars($_POST['password_confirm']);
  $password_confirm = mysqli_real_escape_string($conn,$password_confirm_htmlspecialchar);
  $birthday = mysqli_real_escape_string($conn,$_POST['datee']);

  //Partie vérification

  //Regarde si le pseudo est déjà pris ou non
  //Si oui $result = 1 sinon = 0
  $sql = "SELECT * FROM users WHERE pseudo='$pseudo'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    header('Location: register_error.php?pseudo');
    exit;
  }

  //Check si l'adresse mail est déjà utilisé ou non
  //Si oui $result = 1 sinon = 0
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    header('Location: register_error.php?email');
    exit;
  }

  //Verifier si le mot de passe contient 8 caractères dont une Maj, une Min, un chiffre
  $majuscule = preg_match('@[A-Z]@', $password);
  $minuscule = preg_match('@[a-z]@', $password);
  $chiffre = preg_match('@[0-9]@', $password);
  $length = strlen($password);
  if($majuscule && $minuscule && $chiffre && $length>8){
    //Verifie si le password et password_confirm sont identiques
    if($password==$password_confirm){
      //Regarde si l'utilisateur a plus de 18 ans
      $age = date_diff(date_create($birthday), date_create('today'))->y;
      if ($age >= 18) {
        //Si tout est bon alors 
        $secure = md5($password);
        $default_pfp='uploads/default.png';
        //On envoie dans la base de données
        $sql = "INSERT INTO users(pseudo, email, password, birthday, pfp, isAdmin) 
              VALUES ('$pseudo','$email','$secure', '$birthday', '$default_pfp', '0')";
        $result = mysqli_query($conn, $sql);
        if ($result == TRUE) {
          header('Location: login.php');
          exit;
        }else{
          echo 'Error: . $sql . <br>'. $conn->error;
        }
      }else{
        header('Location: register_error.php?date');
          exit;
      }
    }else{
      header('Location: register_error.php?password');
      exit;
    }
  }else{
    header('Location: register_error.php?condition');
    exit;
  }

  //Ferme la connexion
  $conn->close();
?>
