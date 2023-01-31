<?php
session_start();
require("./include/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./include/stylesheet_inc.php") ?>
    <title>Inscription</title>
</head>

<body>
    <header>
        <?php require('./include/header-include.php') ?>
    </header>

    <main>

        <form method="POST" action="">
            <div class="editelement">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" placeholder="Login" required autofocus autocomplete="off">
            </div>
            <div class="editelement">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="editelement">
                <label for="cpassword">Confirmation</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirmation" required>
            </div>
            <input class="bouton" type="submit" name="envoi" id="button" value="Sign Up">
            <?php
            if (isset($_POST['envoi'])) {
                $login = htmlspecialchars($_POST['login']);
                $password = $_POST['password']; // md5'() pour crypet le mdp

                $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
                $recupUser->execute([$login]);

                if (empty($login) || empty($password) || empty($_POST['cpassword'])) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspVeuillez complétez tous les champs.</p>";
                } elseif (!preg_match("#^[a-z0-9]+$#", $login)) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspLe login doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.</p>";
                } elseif ($password != $_POST['cpassword']) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspLes deux mots de passe sont differents.</p>";
                } elseif ($recupUser->rowCount() > 0) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCe login est déjà utilisé.</p>";
                } else {
                    $insertUser = $bdd->prepare("INSERT INTO utilisateurs(login, password)VALUES(?,?)");
                    $insertUser->execute([$login, $password]);
                    header("Location: connexion.php");
                }
            }
            ?>
        </form>
    </main>
</body>

</html>