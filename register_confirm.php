<?php 
//Connection aux serveurs
  require('fonction.php');
  $conn=conn_start();

//Récupère les informations de register
  $pseudo = mysqli_real_escape_string($conn, $_POST['pseudo']);
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $password = mysqli_real_escape_string($conn,$_POST['password']);
  $password_confirm = mysqli_real_escape_string($conn,$_POST['password_confirm']);
  $birthday = mysqli_real_escape_string($conn,$_POST['datee']);

  //Partie vérification :
   $verif = TRUE;

   //Regarde si le pseudo est déjà pris ou non
   $sql = "SELECT * FROM users WHERE pseudo='$pseudo'";
   $result = mysqli_query($conn, $sql);
   if (mysqli_num_rows($result) > 0) {
    $verif=FALSE;
    header('Location: register_error.php?pseudo');
    exit;
  }

  //Check si l'adresse mail est déjà utilisé ou non
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
   if (mysqli_num_rows($result) > 0) {
    $verif=FALSE;
    header('Location: register_error.php?email');
    exit;
  }

  //Verifier si le mot de passe contient 8 caractères dont une Maj, une Min, un chiffre
  $length = strlen($password);
  $majuscule = preg_match('@[A-Z]@', $password);
  $minuscule = preg_match('@[a-z]@', $password);
  $chiffre = preg_match('@[0-9]@', $password);
  if(!($majuscule && $minuscule && $chiffre && $length>=8)){
    $verif=FALSE;
    header('Location: register_error.php?condition');
    exit;
  }

  //Verifie si le password et password_confirm sont identiques
  if($password!=$password_confirm){
    $verif=FALSE;
    header('Location: register_error.php?password');
    exit;
  }

  //Regarde si l'utilisateur a plus de 18 ans
  if ((new \DateTime())->diff(new \DateTime($birthday))->format('%y') < 18){
    $verif=FALSE;
    header('Location: register_error.php?date');
    exit;
  }

  //Si toutes les vérifications sont bonnes :
  if($verif){
    $secure = md5($password);
    $default_pfp='uploads/default.png';
    //Envoie dans la base de données
    $sql = "INSERT INTO users(pseudo, email, password, birthday, pfp, isAdmin) 
          VALUES ('$pseudo','$email','$secure', '$birthday', '$default_pfp', 'FALSE')";
    $result = mysqli_query($conn, $sql);
  }
  //affiche un message comme quoi le compte a été créer
  if ($result == TRUE) {
    header('Location: login.php');
    exit;
  }else{
    echo 'Error: . $sql . <br>'. $conn->error;
  }
  //Ferme la connexion
  $conn->close();
?>
