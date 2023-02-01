<?php
session_start();
require "./include/config.php";
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
    <title>Edit Profil</title>
</head>

<body>
    <header>
        <?php require './include/header-include.php' ?>
    </header>

    <main>
        <h3>Edit Profile</h3>
        <form method="post" action="profil.php" enctype="multipart/form-data">
            <div class="editelement">
                <label for="login">Avatar</label>
                <input type="file" name="avatar" id="avatar" />
            </div>
            <div class="editelement">
                <label for="login">Login</label>
                <input type="text" name="login" id="login" value="<?= $_SESSION['login'];  ?>" />
            </div>
            <div class="editelement">
                <label>New Password</label>
                <input type="password" name="newpassword" />
            </div>
            <div class="editelement">
                <label>Confirm New Password</label>
                <input type="password" name="cnewpassword" />
            </div>
            <div class="editelement">
                <label>Old password for register</label>
                <input type="password" name="password" required />
            </div>

            <input class="bouton" type="submit" name="envoi" id="button" value="Edit">
            <?php
            // DEBUT DU POST //

            if (isset($_POST['envoi'])) {
                $login = htmlspecialchars($_POST['login']);
                $password = $_POST['password']; // md5'() pour crypet le 
                $newpassword = $_POST['newpassword'];
                $cnewpassword = $_POST['cnewpassword'];
                $avatar = $_POST['avatar'];
                $id = $_SESSION['id'];

                $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND id != ?");
                $recupUser->execute([$login, $id]);
                $insertUser = $bdd->prepare("UPDATE utilisateurs SET login = ? , password=  ? WHERE id = ?");

                if (empty($password)) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspVeuillez complétez tous les champs.</p>";
                } elseif (!preg_match("#^[a-z0-9]+$#", $login)) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspLe login doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.</p>";
                } elseif ($password != $_SESSION['password']) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCe n'est pas le bon mot de passe</p>";
                } elseif ($recupUser->rowCount() > 0) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCe login est déjà utilisé.</p>";
                } else {

                    if ($newpassword == $_SESSION['password'] && $newpassword == $password) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspMot de passe similaire</p>";
                    } elseif ($newpassword == $cnewpassword && $newpassword != null && $cnewpassword != null) {
                        $insertUser->execute([$login, $newpassword, $id]);
                        $_SESSION['login'] = $login;
                        $_SESSION['password'] = $newpassword;
                        header("Location: profil.php");
                    } else {
                        $insertUser->execute([$login, $password, $id]);
                        $_SESSION['login'] = $login;
                        $_SESSION['password'] = $password;
                        header("Location: profil.php");
                    }
                }
                // Rajouter Avatar au moment du Post
                if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
                    $tailleMax = 2097152;
                    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');

                    if ($_FILES['avatar']['size'] <= $tailleMax) {
                        $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                        if (in_array($extensionUpload, $extensionsValides)) {
                            $chemin = "../membres/avatars/" . $_SESSION['id'] . "." . $extensionUpload;
                            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                            if ($resultat) {
                                $updateavatar = $bdd->prepare('UPDATE utilisateurs SET avatar = :avatar WHERE id = :id');
                                $updateavatar->execute(array(
                                    'avatar' => $_SESSION['id'] . "." . $extensionUpload,
                                    'id' => $_SESSION['id']
                                ));
                                header('Location: profil.php?id=' . $_SESSION['id']);
                            } else {
                                $msg = "Erreur durant l'importation de votre photo de profil";
                            }
                        } else {
                            $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
                        }
                    } else {
                        $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
                    }
                }

                /////
            }
            ?>
        </form>
    </main>
</body>

</html>