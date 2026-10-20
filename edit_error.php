
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
	<title>Page de profil</title>
  <link rel="stylesheet" href="editt.css">
</head>
<body>
	
	<?php
    session_start();
    require('fonction.php');
    $conn=conn_start();
    is_connected();

    echo "<nav>";
      require_once('nav.php');
    echo "</nav>";

    $id=$_SESSION["user"];
    
    //prends les informations de l'utilisateurs
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
	?>
  

	<form class="form" id = "form" action="" enctype="multipart/form-data" method="post">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <div class="upload">
        <img src="<?php echo $row['pfp']; ?>" id = "image">

        <div class="rightRound" id = "upload">
            <input type='file' name='fileImg' id='fileImg'>
		    <img src='uploads/camera.png'>
        </div>

        <?php
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

        <div class="leftRound" id = "cancel" style = "display: none;">
            <img src='uploads/nop.png'>
        </div>
        <div class="rightRound" id = "confirm" style = "display: none;">
          <input type="submit">
          <img src='uploads/yup.png'>
        </div>
      </div>
    </form>
    
	<script type="text/javascript">
      document.getElementById("fileImg").onchange = function(){
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); // Preview new image

        document.getElementById("cancel").style.display = "block";
        document.getElementById("confirm").style.display = "block";

        document.getElementById("upload").style.display = "none";
      }

      var userImage = document.getElementById('image').src;
      document.getElementById("cancel").onclick = function(){
        document.getElementById("image").src = userImage; // Back to previous image

        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";

        document.getElementById("upload").style.display = "block";
      }
    </script>

	<?php
  if(isset($_GET['size'])){ 
    echo "<div class='text-center'><small class='form-text text-muted'>La taille maximale de l'image est de 4Mo.</small></div>";
  }
  if(isset($_GET['type'])){ 
    echo "<div class='text-center'><small class='form-text text-muted'>Seules les images jpeg, png, jpg et jfif sont acceptés.</small></div>";
  }
    
		if(isset($_FILES["fileImg"]["name"])){
			$tmp = $_FILES["fileImg"]["tmp_name"];
			$imageName = uniqid(). "-" . $_FILES["fileImg"]["name"];
			$size = $_FILES["fileImg"]['size'];
			$type = $_FILES["fileImg"]['type'];
      
			if($size>4000000){
				header("Location: profile_error.php?size");
				exit;
			}
      
			if($type != "image/jpeg" && $type != "image/png" && $type != "image/jpg" && $type != "image/jfif" ) {
				header("Location: profile_error.php?type");
				exit;
			}
      

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

			$query = "UPDATE users SET pfp = '$upload' WHERE id = '$id'";
			mysqli_query($conn, $query);

			header("Location: profile.php");
		}
    ?>

    <form action="edit_confirm.php" method="post" id="edit"> 
    <?php
        //affiche le pseudo
        echo "<label for='pseudo'>Pseudo :</label>";
        echo "<input type='text' name='pseudo' placeholder='Nouveau pseudo' id='pseudo' value='$row[pseudo]' size=27>";
        if(isset($_GET['pseudo'])){
          echo "<small class='form-text text-muted'>Le pseudo est déjà utilisé.</small>";
          echo "<style> input[type='text']{  border-bottom: 2px solid red;} </style>";
        }
        echo "<br><br>";

        //affiche l'email
        echo "<label for='email'>Email :</label>";
        echo "<input type='email' name='email' placeholder='Nouveau email' id='email' value='$row[email]' size=29>";
        if(isset($_GET['email'])){ 
          echo "<small class='form-text text-muted'>L'email est déjà utilisé.</small>";
          echo "<style> input[type='email']{  border-bottom: 2px solid red;} </style>";
        }
        echo "<br><br>";

        //affiche le password
        echo "<label for='password'>Mot de passe :</label>";
        echo "<input type='password' name='password' placeholder='Nouveau mot de passe' id='password' value='' size = 20>";
        if(isset($_GET['condition'])){
          echo "<small class='form-text text-muted'>Le mot de passe doit faire minimum 8 caratères dont une majuscule, une minuscule et un chiffre .</small>";
          echo "<style> input[type='password']{  border-bottom: 2px solid red;} </style>";
        }
        echo "<br><br>";
	?>
  <div class="submit-button">
	<input type="submit" name="save" value="Save">
  </div>
  </form>
</body>
</html>