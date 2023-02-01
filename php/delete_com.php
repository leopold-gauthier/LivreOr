<?php
session_start();
include_once "./include/config.php";

$recupUser = $bdd->query("SELECT `commentaires`.`id`,`commentaires`.`id_utilisateur` FROM commentaires INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");
$livreor = $recupUser->fetchAll();

// Condition pour renvoyer automatiquement vers l'index si c'est pas un admin
if ($_SESSION['login'] != "admin") {
    header("Location: ../index.php");
}

// premiére condition pour vérifier si la session actuelle est bien égal a l'id_utilisateur du commentaire en question
if (isset($_SESSION['id']) == $livreor['0']['id_utilisateur']) {
    // deuxieme condition pour vérifier si c'est bien de ce commentaire dont on parle
    if ($_GET['id'] == $livreor['0']['id']) {
        // troisieme condition éxecuter le suppresion
        if (isset($_GET['id']) and !empty($_GET['id'])) {

            $suppr_id = htmlspecialchars($_GET['id']);

            $suppr = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
            $suppr->execute(array($suppr_id));

            header('Location: ./livreor.php');
        }
    } else {
        header("Location: ./livreor.php");
    }
}
