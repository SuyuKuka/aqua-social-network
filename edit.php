<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
	<title>Page de profil</title>
  <link rel="stylesheet" href="edit.css">
</head>
<body>
	
	<?php
    session_start();
    require('fonction.php');
    $conn=conn_start();
    is_connected();
    $id=$_SESSION["user"];

    require_once('nav.php');

    //Prends les informations de l'utilisateurs
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
	?>

  <!-- Affiche l'image de profile et la caméra qui permet de changer de photo de profile -->
	<form class="form" id = "form" action="" enctype="multipart/form-data" method="post">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <div class="upload">
        <img src="<?php echo $row['pfp']; ?>" id = "image">

        <div class="rightRound" id = "upload">
            <input type='file' name='fileImg' id='fileImg'>
		      <img src='uploads/camera.png' id='camera'>
        </div>

        <?php
          //Si l'utilisateur a déjà changer sa photo de profile alors on affiche une croix qui lui 
          //permet de supprimer sa photo de profile en mettant celle de base
          $sql = "SELECT * FROM users WHERE id='$id'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          if($row['pfp']!="uploads/default.png"){
            echo "<div class='leftRound' id = 'delete'>";
              echo "<a href='default.php'>";
                echo "<input type='button' name='defaultImg' id='defaultImg'>";
              echo "</a>";
              echo "<img src='uploads/nop.png'>";
            echo "</div>";
          }
        ?>

        <!-- N'affiche pas la croix et valider -->
        <div class="leftRound" id = "cancel" style = "display: none;">
            <img src='uploads/nop.png'>
        </div>

        <div class="rightRound" id = "confirm" style = "display: none;">
          <input type="submit">
          <img src='uploads/yup.png'>
        </div>

      </div>
  </form>
    
  <!-- Permet de visualiser l'image avant de la mettre définitivement -->
	<script type="text/javascript">
      document.getElementById("fileImg").onchange = function(){
        //Montre un l'aperçu de la nouvelle image
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]);

        //Affiche la croix et valider
        document.getElementById("cancel").style.display = "block";
        document.getElementById("confirm").style.display = "block";

        //Masque l'appareil photo
        document.getElementById("upload").style.display = "none";
      }
      
      
      var userImage = document.getElementById('image').src;
      document.getElementById("cancel").onclick = function(){
        //Lorsque qu'on appuyes sur la croix, on remet l'image de base
        document.getElementById("image").src = userImage;

        //Masque a nouveau la croix et valider
        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";

        //Raffiche l'appareil photo
        document.getElementById("upload").style.display = "block";
      }
    </script>

	<?php
		if(isset($_FILES["fileImg"]["name"])){
      //Prends les informations de l'image 
			$tmp = $_FILES["fileImg"]["tmp_name"];
			$imageName = uniqid(). "-" . $_FILES["fileImg"]["name"];
			$size = $_FILES["fileImg"]['size'];
			$type = $_FILES["fileImg"]['type'];
      
      //Les erreurs possibles
			if($size>4000000){
				header("Location: edit_error.php?size");
				exit;
			}
      
			if($type != "image/jpeg" && $type != "image/png" && $type != "image/jpg" && $type != "image/jfif" ) {
				header("Location: edit_error.php?type");
				exit;
			}
      
      //Si tout est bon, on met le fichier dans uploads
			$upload = "uploads/" . $imageName;
			move_uploaded_file($tmp, $upload);

      //Si sa pfp est différente de celle de base, on supprime l'image 
      //existante dans le dossier pour mettre la nouvelle
      //afin d'eviter que le dossier soit trop lourd
      $replace_sql = "SELECT pfp FROM users WHERE id='$id'";
      $replace_result = mysqli_query($conn, $replace_sql);
      $replace_row = mysqli_fetch_assoc($replace_result);
      if($replace_row['pfp']!="uploads/default.png"){
        unlink($replace_row['pfp']);
      }

      //Change la photo de profile
			$query = "UPDATE users SET pfp = '$upload' WHERE id = '$id'";
			mysqli_query($conn, $query);
			header("Location: edit.php");
		}
  ?>

  <form action="edit_confirm.php" method="post" id="edit"> 
    <?php
        //Affiche le pseudo
        echo "<label for='pseudo'>Pseudo :</label>";
        echo "<input type='text' name='pseudo' placeholder='Nouveau pseudo' id='pseudo' value='$row[pseudo]' size=27>";
        echo "<br><br>";

        //Affiche l'email
        echo "<label for='email'>Email :</label>";
        echo "<input type='email' name='email' placeholder='Nouveau email' id='email' value='$row[email]' size=29>";
        echo "<br><br>";

        //Affiche le password
        echo "<label for='password'>Mot de passe :</label>";
        echo "<input type='password' name='password' placeholder='Nouveau mot de passe' id='password' value='' size = 20>";
        echo "<br><br>";
	  ?>
    <div class="submit-button">
      <input type="submit" name="save" value="Enregistrer">
    </div>
  </form>
</body>
</html>