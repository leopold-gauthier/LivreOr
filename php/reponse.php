<?php
session_start();
include_once "./include/config.php";
if (!isset($_SESSION['login'])) {
    header("Location: ./connexion.php");
} else {
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./include/stylesheet_inc.php") ?>
    <title>News</title>
</head>


<body>
    <header>
        <?php include_once "./include/header-include.php"; ?>
    </header>
    <main>
        <?php
        $mode_edition = 0;
        $message = "";

        //////////////////////////////////////////// AFFICHER REPONSE POUR EDITER /////////////////////////////////////////////


        if (isset($_GET['edit']) and !empty($_GET['edit'])) {
            $mode_edition = 1;
            $edit_id = htmlspecialchars($_GET['edit']);
            $edit_commentaire = $bdd->prepare('SELECT reponse FROM reponses WHERE id = ?');
            $edit_commentaire->execute(array($edit_id));
            // verification si il existe
            if ($edit_commentaire->rowCount() == 1) {

                $edit_commentaire = $edit_commentaire->fetch(PDO::FETCH_ASSOC);
            } else {
                // header("Location: ./livreor.php");
            }
        } else {
            // header("Location: ./livreor.php");
        }

        ////////////////////////////////////////// REPONSE ///////////////////////////////////////////////////

        if (isset($_POST['reponse'])) {
            $id_commentaire = $_GET['reponse'];
            $commentaire = $_POST['reponse'];
            $id_utilisateur = $_SESSION['id'];
            $date = date("Y-m-d H:i:s");
            if (!empty($commentaire)) {
                if ($mode_edition == 0) {
                    $getUser = $bdd->prepare("INSERT INTO reponses (reponse, id_utilisateur ,id_commentaire ,date_reponse) VALUES (?,?,?,?)");
                    $getUser->execute([$commentaire, $id_utilisateur, $id_commentaire, $date]);
                    $message = "Votre message a bien été posté";
                    header("Location: ./livreor.php");
                } else {
                    $update = $bdd->prepare('UPDATE reponses SET reponse = ? , date_reponse = ? WHERE id = ?');
                    $update->execute([$commentaire, $date, $edit_id]);
                    $message = "Votre message a bien été édité !";
                    // header("Location: ./livreor.php");
                }
            } else {
                $message = "Veuillez écrire un commentaire";
            }
        }

        ?>
        <h3>
            <?php

            if ($mode_edition == 1) {
                echo "Modifier reponse";
            } elseif ($mode_edition == 0) {
                echo "Répondre";
            }
            ?>
        </h3>
        <form method="post" action="">
            <div class="editelement">
                <label>Commenter</label><br>
                <textarea name="reponse">
                    <?php
                    if ($mode_edition == 1) {
                        echo htmlspecialchars($edit_commentaire['reponse']);
                    }
                    ?>
                </textarea>
            </div>
            <input class="bouton" type="submit" name="submit" value="Envoyer le message">
            <p><?= $message ?></p>

        </form>

    </main>
</body>

</html>