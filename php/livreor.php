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
            // DECLARATION SQL
            $recupUser = $bdd->query("SELECT `commentaires`.`id`,`commentaires`.`id_utilisateur`, login, avatar, commentaire , date FROM commentaires  JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");
            $livreor = $recupUser->fetchAll(PDO::FETCH_ASSOC);

            $recupReponse = $bdd->query("SELECT utilisateurs.login, utilisateurs.avatar, reponses.id, reponses.id_utilisateur,reponses.id_commentaire, reponses.reponse, reponses.date_reponse FROM reponses JOIN utilisateurs ON reponses.id_utilisateur = utilisateurs.id JOIN commentaires ON reponses.id_commentaire = commentaires.id ORDER BY date_reponse DESC;");
            $reponse = $recupReponse->fetchAll(PDO::FETCH_ASSOC);

            ///// AFFICHER COMMENTAIRE ////
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
                    <p>
                        <i>
                            <?= $livreor[$i]['commentaire'] ?>
                        </i>
                    </p>
                    <div id="modified">
                        <?php
                        if (isset($_SESSION['login']) == null) {
                            echo "";
                        } elseif ($livreor[$i]['login'] == $_SESSION['login'] || $_SESSION['login'] == 'admin') { ?>
                            <a href="./delete_com.php?id=<?= $livreor[$i]['id'] ?>">Supprimer</a>
                            |
                            <a href="./commentaire.php?edit=<?= $livreor[$i]['id'] ?>">Editer</a>
                        <?php
                        } elseif ($livreor[$i]['login'] != $_SESSION['login']) {
                            // var_dump($reponse[$i]);
                            // var_dump($_SESSION);

                            // 1 quand j'appui sur sur l'ancre répondre ca ouvre l'include 
                            // 2 en meme temp je veux que l'url prenne l'id du commentaire 
                            // 3 je fait une condition pour reponse dans la tables reponses prenne les valeurs
                        ?>
                            <a href="./commentaire.php?reponse=<?= $livreor[$i]['id'] ?>">Répondre</a>
                        <?php
                        }
                        ?>
                    </div>


                    <!-- //// AFFICHER REPONSE //// -->
                    <?php
                    $recupReponse = $bdd->query("SELECT utilisateurs.login, utilisateurs.avatar, reponses.id, reponses.id_utilisateur,reponses.id_commentaire, reponses.reponse, reponses.date_reponse FROM reponses JOIN utilisateurs ON reponses.id_utilisateur = utilisateurs.id JOIN commentaires ON reponses.id_commentaire = commentaires.id ORDER BY date_reponse DESC;");
                    $reponse = $recupReponse->fetchAll();

                    for ($a = 0; $a < sizeof($reponse); $a++) :
                        if ($reponse[$a]['id_commentaire'] == $livreor[$i]['id']) {

                    ?>
                            <div class="reponse">
                                <h2><?php if ($reponse[$a]['login'] === 'admin') {
                                        echo "<img height='21px' src='../css/icone-utilisateur-rouge.png'>";
                                    } else { ?>
                                        <img src='../membres/avatars/<?= $reponse[$a]['avatar'] ?>'>
                                    <?php
                                    }
                                    ?>
                                    Réponse de <?= $reponse[$a]['login'] ?> le <?= $reponse[$a]['date_reponse'] ?>
                                </h2>
                                <p>
                                    <i>
                                        <?= $reponse[$a]['reponse'] ?>
                                    </i>
                                </p>
                                <div id="modified">
                                    <?php
                                    if (isset($_SESSION['login']) == null) {
                                        echo "";
                                    } elseif ($reponse[$a]['login'] == $_SESSION['login'] || $_SESSION['login'] == 'admin') { ?>
                                        <a href="./delete_com.php?id=<?= $livreor[$i]['id'] ?>">Supprimer</a>
                                        |
                                        <a href="./commentaire.php?edit=<?= $livreor[$i]['id'] ?>">Editer</a>
                                    <?php
                                    } elseif ($livreor[$i]['login'] != $_SESSION['login']) { ?>
                                        <a href="./livreor.php?reponse=<?= $livreor[$i]['id'] ?>">Répondre</a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>

                    <?php
                        }
                    endfor; //  include_once("./include/reponse-include.php")

                    ?>
                </div>
            <?php
            endfor;
            ?>


        </main>
</body>

</html>