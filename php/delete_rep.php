<?php
session_start();
include_once "./include/config.php";

$recupUser = $bdd->query("SELECT `commentaires`.`id`,`commentaires`.`id_utilisateur` FROM commentaires INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateur ORDER BY date DESC");
$livreor = $recupUser->fetchALL(PDO::FETCH_ASSOC);
//PROBLEME DE CONDITION PEUX PAS SUPPRIMER SI JE SUIS DECONNECTER MAIS JE PEUX SUR NIMPORTE QUEL COMPTE LE QUAND JE LE SUIS
// premiére condition pour vérifier si la session actuelle est bien égal a l'id_utilisateur du commentaire en question
if (isset($_GET['id']) == $livreor[0]['id'] && isset($_SESSION['id']) == $livreor[0]['id_utilisateur']) {
    // deuxieme condition pour vérifier si c'est bien de ce commentaire dont on parle
    // troisieme condition éxecuter le suppresion
    if (isset($_GET['id']) and !empty($_GET['id'])) {

        $suppr_id = htmlspecialchars($_GET['id']);

        $suppr = $bdd->prepare('DELETE FROM reponses WHERE id = ?');
        $suppr->execute(array($suppr_id));

        header('Location: ./livreor.php');
    }
} else {
    // header("Location: ./livreor.php");
    echo 'id ou la session ne correspond pas';
}

// RAJOUTER LE BOUTON SUPPRIMER

// if (isset($_GET['id']) == $livreor[0]['id'] && isset($_SESSION['id']) == $livreor[0]['id_utilisateur']) {
//     // deuxieme condition pour vérifier si c'est bien de ce commentaire dont on parle
//     // troisieme condition éxecuter le suppresion
//     if (isset($_GET['id']) and !empty($_GET['id'])) {

//         $suppr_id = htmlspecialchars($_GET['id']);

//         $suppr = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
//         $suppr->execute(array($suppr_id));

//         header('Location: ./livreor.php');
//     }
// } else {
//     // header("Location: ./livreor.php");
//     echo 'id ou la session ne correspond pas';
// }
