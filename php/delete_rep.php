<?php
session_start();
include_once "./include/config.php";

$recupUser = $bdd->query("SELECT reponses.id , reponses.id_utilisateur FROM reponses JOIN utilisateurs ON utilisateurs.id = reponses.id_utilisateur JOIN commentaires ON commentaires.id = reponses.id_commentaire ; ");
$livreor = $recupUser->fetchALL(PDO::FETCH_ASSOC);
var_dump($livreor);
var_dump($_SESSION);
//PROBLEME DE CONDITION PEUX PAS SUPPRIMER SI JE SUIS DECONNECTER MAIS JE PEUX SUR NIMPORTE QUEL COMPTE LE QUAND JE LE SUIS
// premiére condition pour vérifier si la session actuelle est bien égal a l'id_utilisateur du commentaire en question
// isset($_GET['id']) === isset($livreor[0]['id']) && 
if (
    isset($_SESSION['id']) == $livreor[0]['id_utilisateur'] && isset($_GET['id']) == $livreor[0]['id']

) {
    // deuxieme condition pour vérifier si c'est bien de ce commentaire dont on parle
    // troisieme condition éxecuter le suppresion
    if (isset($_GET['id']) and !empty($_GET['id'])) {

        $suppr_id = htmlspecialchars($_GET['id']);

        $suppr = $bdd->prepare('DELETE FROM reponses WHERE id = ?');
        $suppr->execute(array($suppr_id));

        header('Location: ./livreor.php');
    }
} else {
    //     // header("Location: ./livreor.php");
    echo 'id ou la session ne correspond pas';
}
