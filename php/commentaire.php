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
        //"SELECT * FROM commentaires  JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur JOIN reponses ON reponses.id_commentaire = commentaires.id WHERE = ?");
        $recupUser = $bdd->query("SELECT * FROM commentaires  JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur JOIN reponses ON reponses.id_commentaire = commentaires.id ");
        $livreor = $recupUser->fetchALL(PDO::FETCH_ASSOC);

        // var_dump($livreor);
        //////////////////////////////////////////// AFFICHER COMMENTAIRE POUR EDITER /////////////////////////////////////////////
        $mode_edition = 0;
        $message = "";

        // if (isset($_GET['edit']) == $livreor[0]['id'] && isset($_SESSION['id']) == $livreor['id_utilisateur']) {
        // echo 'tout correspond';
        if (isset($_GET['edit']) and !empty($_GET['edit'])) {
            $mode_edition = 1;
            $edit_id = htmlspecialchars($_GET['edit']);
            $edit_commentaire = $bdd->prepare('SELECT commentaire FROM commentaires WHERE id = ?');
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
        // } else {
        //     // header("Location: ./livreor.php");
        //     echo 'id ou la session ne correspond pas';
        // }

        //MOMENT DU POST

        if (isset($_POST['commentaire'])) {
            ////////////////////////////////////////// COMMENTAIRE ///////////////////////////////////////////////////
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

        ?>
        <h3>
            <?php
            if ($mode_edition == 1) {
                echo "Modifier";
            } elseif ($mode_edition == 0) {
                echo "Ajouter";
            }
            ?>
        </h3>
        <form method="post" action="">
            <div class="editelement">
                <label>Commenter</label><br>
                <textarea name="commentaire">
                    <?php
                    if ($mode_edition == 1) {
                        echo htmlspecialchars($edit_commentaire['commentaire']);
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