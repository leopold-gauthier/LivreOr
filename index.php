<?php
session_start();
require "./php/include/config.php"
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/general_stylesheet.css">
    <script src="https://kit.fontawesome.com/44c9193141.js" crossorigin="anonymous"></script>
    <title>Accueil</title>
</head>


<body>
    <header>
        <nav>
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="./index.php">ACCUEIL</a>';
                echo '<a href="./php/profil.php">PROFILE</a>';
                echo "<a href='./php/livreor.php'>NEWS</a>";
                if ($_SESSION['login'] == 'admin') {
                    echo '<a href="./php/admin.php">ADMIN</a>';
                }
                echo '<a href="./php/logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                </a>';
            } else {
                echo '<a href="./index.php">ACCUEIL</a>';
                echo "<a href='./php/livreor.php'>NEWS</a>";
                echo '<a href="./php/connexion.php">SE CONNECTER</a>';
                echo "<a href='./php/inscription.php'>S'INSCRIRE</a>";
            }
            ?>
        </nav>
    </header>

    <main>
        <h1>
            <?php
            if (isset($_SESSION['login'])) {
                echo "Welcome back " . $_SESSION['login'] . " !";
            } else {
                echo "Welcome";
            }
            ?>
        </h1>
        <h3>Bienvenue sur ce projet !</h3>
    </main>
</body>

</html>