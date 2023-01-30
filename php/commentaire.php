<?php
session_start();
include_once "./include/config.php";

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
        <form method="post" action="">
            <label>Commentaire</label><br>
            <textarea id="commentaire" name="commentaire" cols="50" rows="7"></textarea><br>
            <input type="submit" name="submit" value="Envoyer le message">
            <?php
            if (isset($_POST["submit"])) {
                $commentaire = htmlspecialchars($_POST['commentaire']);
                $id_utilisateur = $_SESSION['users'][0]['id'];
                $date = date("Y-m-d H:i:s");

                if (!empty($commentaire)) {

                    $userId = $_SESSION["users"][0]["id"];
                    $getUser = $bdd->prepare("INSERT INTO commentaires (commentaire, id_utilisateur ,date) VALUES (?,?,?)");

                    $getUser->bindValue(":id_utilisateur", $id_utilisateur);
                    $getUser->execute([$commentaire, $id_utilisateur, $date]);

                    echo "Le commentaire est validé";
                } else {
                    echo "Veuillez écrire un commentaire";
                }
            }
            ?>
        </form>
    </main>
</body>

</html>