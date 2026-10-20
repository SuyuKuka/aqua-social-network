<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>
        Se connecter sur NOM_DU_RESEAU
    </title>
    <link rel="stylesheet" href="register&login.css">
</head>

<body>
    <h1>
       Connectez-vous à NOM_DU_RESEAU
    </h1>

    <form action="login_confirm.php" method="post">
        <label for="email">Adresse email :</label>
        <input type="email" name="email" id="email" required>
        <?php
            if(isset($_GET['email'])){
                echo "<small class='form-text text-muted'>L'adresse mail est incorrect.</small>";
                echo "<style> input[type='email']{  border-bottom: 2px solid red;} </style>";
            }
        ?>
        <br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" minlength="8" required>
        <?php
            if(isset($_GET['password'])){
                echo "<small class='form-text text-muted'>Le mot de passe est incorrect.</small>";
                echo "<style> input[type='password']{  border-bottom: 2px solid red;} </style>";
            }
        ?>
        <br><br>

        <div class="submit-button">
            <input type="submit" value="Se connecter" name="send">
        </div>
        <p>
        Vous n'êtes pas encore inscrit? <a href="register.php"> Inscrivez-vous</a>.
        </p>
    </form>

</body>
</html>