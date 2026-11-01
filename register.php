<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>
        S'inscrire sur Aqua
    </title>
    <link rel="stylesheet" href="register&login.css">
</head>

<body>
    <h1>
        Créer votre compte
    </h1>

    <form action="register_confirm.php" method="post">
        <div class="form-css">
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" required>
            <br><br>

            <label for="email">Adresse email :</label>
            <input type="email" name="email" id="email" required>
            <br><br>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" minlength="8" required>
            <br><br>

            <label for="password_confirm">Confirmer le mot de passe :</label>
            <input type="password" name="password_confirm" id="password_confirm" minlength="8" required>
            <br><br>

            <label for="datee">Date de naissance :</label>
            <input type="date" name="datee" id="datee" required>
            <br><br>
            <div class="submit-button">
                <input type="submit" value="S'inscrire" name="send">
            </div>
        </div>
        <p>
            Vous avez déjà un compte? <a href="login.php"> Connectez-vous ici</a>.
        </p>
    </form> 
</body>
</html>