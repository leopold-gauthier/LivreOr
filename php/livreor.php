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
    <title>Livre d'Or</title>
    <style>
        @media screen and (max-width: 425px) {
            main {
                margin: 0%;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include_once "./include/header-include.php"; ?>
    </header>
    <div id="message">
        <div id="main_button">
            <?php
            if (isset($_SESSION['login'])) { ?>
                <a class="bouton" href="./commentaire.php">Ajouter ?</a>
            <?php
            } else { ?>
                <a class="bouton" href="./connexion.php">Se Connecter</a>
            <?php
            }
            ?>
        </div>
        <main>
            <h1><u>News</u></h1>
            <?php
            $recupUser = $bdd->query("SELECT login, avatar, commentaire , date FROM commentaires INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");
            $livreor = $recupUser->fetchAll();
            for ($i = 0; $i < sizeof($livreor); $i++) :
            ?>

                <div class="message">
                    <h2><?php if ($livreor[$i]['login'] === 'admin') {
                            echo "<img height='21px' src='../css/icone-utilisateur-rouge.png'>";
                        } else { ?>
                            <img src='../membres/avatars/<?= $livreor[$i]['avatar'] ?>'>
                        <?php
                        }
                        ?>
                        Posté par <?= $livreor[$i]['login'] ?> le <?= $livreor[$i]['date'] ?>
                    </h2>
                    <p><i><?= $livreor[$i]['commentaire'] ?></i></p>
                </div>


            <?php
            endfor
            ?>
        </main>
    </div>
</body>

</html>