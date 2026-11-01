<?php
	session_start();
	require('fonction.php');
	is_connected();
	if(!isset($_GET['u']) || $_GET['u']==""){
		$conn=conn_start();
		$id=mysqli_real_escape_string($conn,$_SESSION['user']);
        $sql="SELECT pseudo FROM users WHERE id='$id'";
        $result=mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
		$user=$row['pseudo'];
		header("Location: profile.php?u=$user");
	}
?>

<html>
<head>
    <meta charset="utf-8">
	<title>Page de profil</title>
	<link rel="stylesheet" href="profile.css">
</head>
<body>
	<?php require_once('nav.php'); ?>
	<div class="content">
		<?php 
			$user=mysqli_real_escape_string($conn,$_GET['u']);  
			$sql="SELECT id,pseudo FROM users WHERE pseudo='$user' OR id='$user'";
			$result=mysqli_query($conn,$sql);

			//On vérifie que l'utilisateur existe:
			if(mysqli_num_rows($result)>0){
				//On récupère les informations de l'utilisateur pour les afficher:
				$pseudo=mysqli_real_escape_string($conn,$_GET['u']);
				$sql="SELECT id,pfp FROM users WHERE pseudo='$pseudo'";
				$result=mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);

				//On récupère le nombre d'abonnements et d'abonnés de l'utilisateur:
				$abonnes = "SELECT * FROM subs WHERE subto=$row[id]";
				$result_abonnes = mysqli_query($conn, $abonnes);
				$nb_abonnes = mysqli_num_rows($result_abonnes);

				$abonnements = "SELECT * FROM subs WHERE user=$row[id]";
				$result_abonnements = mysqli_query($conn, $abonnements);
				$nb_abonnements = mysqli_num_rows($result_abonnements);

				//Affichage des informations du profil:
					echo "<section class='data'>";

						//Affiche la photo de profile
						echo "<section class='col1'>";
							echo "<img src='$row[pfp]' id='image'> <br>";
						echo "</section>";
						
						//Affiche ses informations
						echo "<section class='col2'>";    
							echo "<label for='pseudo'>$_GET[u]</label> <br>";
							echo "<label for='id'>id : $row[id]</label> <br>";
							echo "<label for='abonne'>$nb_abonnes" . " abonné(s) </label> <br>";
							echo "<label for='abonnement'>$nb_abonnements" . " abonnement(s)</label><br><br>";
							//Afficher le bouton d'abonnement si ce n'est pas la page de l'utilisateur:
							if($row['id']!=$_SESSION['user']){
								subButton($row['id']);
							}
						echo "</section>";

					echo "</section>";

				echo "<h1> Publications: </h1>";
				
				echo "<div class='display'>";
					require_once('profile_process.php'); 
				echo "</div>";
			} else {
				echo "L'utilisateur n'existe pas."; 
			}
		?>
	</div>
</body>
</html>