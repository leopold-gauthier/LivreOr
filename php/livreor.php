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
            $recupUser = $bdd->query("SELECT `commentaires`.`id`,`commentaires`.`id_utilisateur`, login, avatar, commentaire , date FROM commentaires  JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");
            $livreor = $recupUser->fetchAll(PDO::FETCH_ASSOC);
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
                        // // REPONDRE
                        //         -faire un style différent pour l'ancre répondre
                        //         -faire une page répondre (potentiellement en include)

                        // EDITER  /  SUPPRIMER / REPONDRE
                        if (isset($_SESSION['login']) == null) {
                            echo "";
                        } elseif ($livreor[$i]['login'] == $_SESSION['login'] || $_SESSION['login'] == 'admin') { ?>
                            <a href="./delete_com.php?id=<?= $livreor[$i]['id'] ?>">Supprimer</a>
                            |
                            <a href="./commentaire.php?edit=<?= $livreor[$i]['id'] ?>">Editer</a>
                        <?php
                        } elseif ($livreor[$i]['login'] != $_SESSION['login']) { ?>
                            <a href="./livreor.php?reponse=<?= $livreor[$i]['id'] ?>">Répondre</a>
                        <?php
                        }
                        ?>
                        <?php
                        $recupReponse = $bdd->query("SELECT utilisateurs.login, utilisateurs.avatar, reponses.id, reponses.id_utilisateur,reponses.id_commentaire, reponses.reponse, reponses.date_reponse FROM reponses JOIN utilisateurs ON reponses.id_utilisateur = utilisateurs.id JOIN commentaires ON reponses.id_commentaire = commentaires.id ORDER BY date_reponse DESC;");
                        $reponse = $recupReponse->fetchAll();

                        if ($reponse[0]['id_commentaire'] == $livreor[$i]['id']) {
                            for ($a = 0; $a < sizeof($reponse); $a++) {
                                // var_dump($reponse); 
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
                                </div>

                        <?php
                            } //  include_once("./include/reponse-include.php")
                        }
                        ?>
                    </div>
                </div>
            <?php
            endfor;
            ?>
        </main>
</body>

</html>
<?php
// PROBLEME DE CONDITION PEUX PAS SUPPRIMER SI JE SUIS DECONNECTER MAIS JE PEUX SUR NIMPORTE QUEL COMPTE LE QUAND JE LE SUIS
// premiére condition pour vérifier si la session actuelle est bien égal a l'id_utilisateur du commentaire en question
// if (isset($_GET['id']) == $livreor[0]['id'] && isset($_SESSION['id']) === $livreor[0]['id_utilisateur']) {

//     if (isset($_GET['id']) and !empty($_GET['id'])) {

//         // $suppr_id = htmlspecialchars($_GET['id']);

//         // $suppr = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
//         // $suppr->execute(array($suppr_id));

//         // header('Location: ./livreor.php');
//     }
// } else {
//     // header("Location: ./livreor.php");
//     // echo 'id ou la session ne correspond pas';
// }
?>