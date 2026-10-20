<?php
	session_start();
	require('fonction.php');
    $conn=conn_start();

	// Vérifier si l'utilisateur est connecté
	is_connected();

	// Vérifier si le formulaire de suppression a été soumis
	if(isset($_POST['message_id'])) {
		$message_id = $_POST['message_id'];
		$user_id = $_SESSION['user'];
		// Vérifier si l'utilisateur est admin ou l'auteur du message
		if(isAdmin($user_id) || isAuthor($message_id, $user_id)) {
			//Supprime l'image dans le dossier release
			$delete_sql="SELECT image FROM message WHERE id=$message_id";
			$delete_result = mysqli_query($conn, $delete_sql);
			$delete_row=mysqli_fetch_assoc($delete_result);
			unlink($delete_row["image"]);

			// Supprimer le message de la base de données
			$sql = "DELETE FROM message WHERE id=$message_id";
			$result = mysqli_query($conn, $sql);
			
			if($result) {
				// Rediriger vers la page de profil de l'utilisateur correspondant
				header("Location: profile.php?u=".$_POST['pseudo']."&success");
				exit();
			} else {
				// Rediriger vers la page de profil de l'utilisateur correspondant avec un message d'erreur
				header("Location: profile.php?u=".$_POST['pseudo']."&error");
				exit();
			}
		} else {
			// Rediriger vers la page de profil de l'utilisateur correspondant avec un message d'erreur
			header("Location: profile.php?u=".$_POST['pseudo']."&error");
			exit();
		}
	} else {
		// Rediriger vers la page de profil de l'utilisateur correspondant
		header("Location: profile.php?u=".$_POST['pseudo']);
		exit();
	}
?>