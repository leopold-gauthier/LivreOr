<?php
session_start();
require "./include/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./include/stylesheet_inc.php") ?>
    <title>Connexion</title>
</head>

<body>
    <header>
        <?php require './include/header-include.php' ?>
    </header>
    <main>
        <form method="POST" action="">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" placeholder="Login" required autofocus autocomplete="off">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder='Password' required autocomplete="off">
            <input class="bouton" type="submit" name="envoi" value="Log In" id="button">
            <?php
            if (isset($_POST['envoi'])) {
                $login = htmlspecialchars($_POST['login']);
                $password = $_POST['password']; // md5'() pour crypet le mdp

                if (!empty($login) && !empty($password)) {
                    $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
                    $recupUser->execute([$login, $password]);

                    if ($recupUser->rowCount() > 0) {
                        $_SESSION['login'] = $login;
                        $_SESSION['password'] = $password;
                        $recupUser = $recupUser->fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION = $recupUser[0];
                        header("Location: ../index.php");
                    } else {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspVotre login ou mot de passe incorect.</p>";
                    }
                } else {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspVeuillez compléter tous les champs.</p>";
                }
            }
            ?>
        </form>
    </main>

</body>

</html>