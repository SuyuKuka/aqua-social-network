<?php
$conn=conn_start();

$id = mysqli_real_escape_string($conn,$_SESSION['user']);
//on récupère les infos de l'utilisateur
$sql = "SELECT pseudo,pfp FROM users WHERE id='$id'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

echo "<nav>";

echo "Pseudo: $row[pseudo]<br>";
if(isAdmin($id)){
  echo "Admin account : $id<br>";
}else{
  echo "User id: $id <br>";
}
?>

  <a href="home.php">Page d'accueil</a>
  <a href="profile.php">Page de profil</a>
  <a href="search.php">Page de recherche</a>
  <a href="edit.php">Paramètres</a>
  <a href="logout.php">Déconnexion</a>
</nav> 