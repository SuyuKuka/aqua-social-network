<?php
	$conn = conn_start();
	$pseudo = mysqli_real_escape_string($conn, $_GET['u']);

	$sql = "SELECT u.pfp, m.id, m.user_id, m.message, m.timestamp, m.image 
			FROM users AS u, message AS m 
			WHERE u.pseudo='$pseudo' AND u.id=m.user_id 
			ORDER BY m.id DESC";
	$result = mysqli_query($conn, $sql);

	//Si l'utilisateur a des publications, les afficher:
	if(mysqli_num_rows($result) > 0) {
		foreach($result as $array) {
			echo "<div class='message'>";

				echo "<section class='info'>";
					//Affiche la photo de profile
					echo "<section class='pfp'>";
						echo "<img src='$array[pfp]' id='pfp'> <br>";
					echo "</section>";
					//Affiche ses informations
					echo "<section class='user'>";
						echo "<label for='profile-pseudo'>$pseudo</label> <br>";
						echo "<label for='profile-id'>id: $array[user_id]</label> <br>";
						echo "<label for='profile-time'>$array[timestamp]</label> <br>";

						//Affiche ses messages
						echo "<div class='separe'>";
							echo "$array[message] <br>";
							if(!empty($array['image'])) {
								echo "<img src='$array[image]' id='post-image'>"; 
							}
						echo "</div>";

					echo "</section>";

				echo "</section>";

				echo "<a href='post_details.php?p=$array[id]' id='details'> Détails de la publication  </a>";

			echo "</div>";
		}
	} else {
		echo "<p class='no-message'>$pseudo n'a aucune publication</p>";
	}
?>