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
</head>


<body>
    <header>
        <?php include_once "./include/header-include.php"; ?>
    </header>
    <main>
        <?php
        $getUser = $bdd->query("SELECT login, commentaire , date FROM commentaires INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");

        $livreor = $getUser->fetchAll();

        foreach ($livreor as $key) {
            for ($i = 0; $i < sizeof($livreor); $i++) { ?>
                <p>Posté par <?= $livreor[$i]['login'] ?> le <?= $livreor[$i]['date'] ?><br>
                    Text : <?= $livreor[$i]['commentaire'] ?></p>


        <?php }
        }
        ?>
    </main>
</body>

</html>