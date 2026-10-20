<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>
        S'inscrire sur NOM_DU_RESEAU
    </title>
    <link rel="stylesheet" href="register&login.css">
</head>

<body>
    <text> 
    <h1>
        Créer votre compte
    </h1>

    <form action="register_confirm.php" method="post">
        <div class="form-css">
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" required>
            <?php
                if(isset($_GET['pseudo'])){
                    echo "<small class='form-text text-muted'>Le pseudo est déjà utilisé.</small>";
                    echo "<style> input[type='text']{  border-bottom: 2px solid red;} </style>";
                }
            ?>
            <br><br>

            <label for="email">Adresse email :</label>
            <input type="email" name="email" id="email" required>
            <?php
                if(isset($_GET['email'])){ 
                    echo "<small class='form-text text-muted'>L'email est déjà utilisé.</small>";
                    echo "<style> input[type='email']{  border-bottom: 2px solid red;} </style>";
                }
            ?>
            <br><br>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" minlength="8" required>
            <?php
                if(isset($_GET['password'])){
                    echo "<small class='form-text text-muted'>Les mots de passes ne sont pas identiques.</small>";
                    echo "<style> input[type='password']{  border-bottom: 2px solid red;} </style>";
                }
                if(isset($_GET['condition'])){
                    echo "<small class='form-text text-muted'>Le mot de passe doit faire minimum 8 caratères dont une majuscule, une minuscule et un chiffre .</small>";
                    echo "<style> input[type='password']{  border-bottom: 2px solid red;} </style>";
                }
            ?>
            <br><br>

            <label for="password_confirm">Confirmer le mot de passe :</label>
            <input type="password" name="password_confirm" id="password_confirm" minlength="8" required>
            <?php
                if(isset($_GET['password'])){
                    echo "<small class='form-text text-muted'>Les mots de passes ne sont pas identiques.</small>";
                    echo "<style> input[type='password_confirm']{  border-bottom: 2px solid red;} </style>";
                }
                if(isset($_GET['condition'])){
                    echo "<small class='form-text text-muted'>Le mot de passe doit faire minimum 8 caratères dont une majuscule, une minuscule et un chiffre .</small>";
                    echo "<style> input[type='password']{  border-bottom: 2px solid red;} </style>";
                  }
            ?>
            <br><br>

            <label for="datee">Date de naissance :</label>
            <input type="date" name="datee" id="datee" required>
            <?php
                if(isset($_GET['datee'])){
                    echo "<small class='form-text text-muted'>Vous n'êtes pas encore majeur/e.</small>";
                    echo "<style> input[type='date']{  border-bottom: 2px solid red;} </style>";
                }
            ?>
            <br><br>
            <div class="submit-button">
                <input type="submit" value="S'inscrire" name="send">
            </div>
        </div>
        <p>
        Vous avez déjà un compte? <a href="login.php"> Connectez-vous ici</a>.
        </p>
    </form>
    </text>
</body>
</html>