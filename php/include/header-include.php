<nav>
    <?php
    if (isset($_SESSION['login'])) {
        echo '<a href="../index.php">ACCUEIL</a>';
        echo '<a href="./profil.php">PROFILE</a>';
        echo "<a href='./commentaire.php'>AJOUT</a>";
        echo "<a href='./livreor.php'>NEWS</a>";
        if ($_SESSION['login'] == 'admin') {
            echo '<a href="./admin.php">ADMIN</a>';
        }
        echo '<a href="./logout.php">LOGOUT</a>';
    } else {
        echo '<a href="../index.php">ACCUEIL</a>';
        echo '<a href="./connexion.php">SE CONNECTER</a>';
        echo "<a href='./inscription.php'>S'INSCRIRE</a>";
    } ?>
</nav>