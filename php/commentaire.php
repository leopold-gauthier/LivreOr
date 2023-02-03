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
        //////////////////////////////////////////// PARTIE COMMENTAIRE /////////////////////////////////////////////
        $mode_edition = 0;
        if (isset($_GET['edit']) and !empty($_GET['edit'])) {
            $mode_edition = 1;
            $edit_id = htmlspecialchars($_GET['edit']);
            $edit_commentaire = $bdd->prepare('SELECT commentaire FROM commentaires WHERE id = ?');
            $edit_commentaire->execute(array($edit_id));

            // verification si il existe
            if ($edit_commentaire->rowCount() == 1) {

                $edit_commentaire = $edit_commentaire->fetch(PDO::FETCH_ASSOC);
            } else {
                //erreur l'id n'existe pas
                header("Location: ./livreor.php");
            }
        }

        $message = "";
        if (isset($_POST['commentaire'])) {
            $commentaire = $_POST['commentaire'];
            $id_utilisateur = $_SESSION['id'];
            $date = date("Y-m-d H:i:s");
            if (!empty($commentaire)) {
                if ($mode_edition == 0) {
                    $userId = $_SESSION["id"];
                    $getUser = $bdd->prepare("INSERT INTO commentaires (commentaire, id_utilisateur ,date) VALUES (?,?,?)");

                    $getUser->bindValue(":id_utilisateur", $id_utilisateur);
                    $getUser->execute([$commentaire, $id_utilisateur, $date]);
                    $message = "Votre message a bien été posté";
                    header("Location: ./livreor.php");
                } else {
                    // HERE
                    // need condition pour vérifier si bien le bon users qui veut modifier
                    $update = $bdd->prepare('UPDATE commentaires SET commentaire = ? , date_time_edition = ? WHERE id = ?');
                    $update->execute([$commentaire, $date, $edit_id]);
                    header("Location: ./livreor.php");
                }
            } else {
                $message = "Veuillez écrire un commentaire";
            }
        }
        //////////////////////////////////////////////////////// REPONSE //////////////////////
        // TODO
        if (isset($_GET['reponse']) and !empty($_GET['reponse'])) {
            $mode_reponse = 1;
            $reponse = htmlspecialchars($_GET['reponse']);
            $reponse_com = $bdd->prepare('SELECT reponse FROM reponses WHERE id = ?');
            $reponse_com->execute(array($reponse));


            /////TODO
            //BUG AU NIVEAU DE LA REPONSE LA REQUETE PAR AU COMMENTAIRE ET NON A LA REPONSE !!
        }
        if (isset($_POST['reponse'])) {
            $reponse = $_POST['reponse'];
            $id_commentaire = $_GET['reponse'];
            $id_utilisateur = $_SESSION['id'];
            $date = date("Y-m-d H:i:s");
            if (!empty($reponse)) {
                $getReponse = $bdd->prepare("INSERT INTO reponses (reponse, id_utilisateur ,id_commentaire  ,date_reponse) VALUES (?,?,?,?)");
                $getReponse->bindValue(":id_utilisateur", $id_utilisateur, ":id_commentaire", $id_commentaire);
                $getReponse->execute([$reponse, $id_commentaire, $id_utilisateur, $date]);
                $message = "Votre message a bien été posté";
                header("Location: ./livreor.php");
            } else {
                // HERE
                // need condition pour vérifier si bien le bon users qui veut modifier
                $update = $bdd->prepare('UPDATE reponses SET reponse = ? , date_reponse = ? WHERE id = ?');
                $update->execute([$commentaire, $date, $edit_id]);
                header("Location: ./livreor.php");
            }
        } else {
            $message = "Veuillez écrire un commentaire";
        }
        ?>
        <h3>
            <?php
            if ($mode_edition == 1) {
                echo "Modifier";
            } elseif ($mode_edition == 0) {
                echo "Ajouter";
            } else if ($mode_reponse_edition == 1) {
                echo "Modifier votre réponse";
            } elseif ($mode_reponse_edition == 0) {
                echo "Répondre";
            }
            ?>
        </h3>
        <form method="post" action="">
            <div class="editelement">
                <label>Commenter</label><br>
                <textarea name="commentaire" cols="50" rows="7">
                    <?php
                    if ($mode_edition == 1) {
                        echo $edit_commentaire['commentaire'];
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