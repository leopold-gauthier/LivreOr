-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 31 jan. 2023 à 15:22
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `livreor`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commentaire` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_utilisateur` int NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `commentaire`, `id_utilisateur`, `date`) VALUES
(20, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Est maiores consequatur dolor ab sit qui iste delectus. Deserunt doloremque, quam officiis, culpa saepe quis dolor et dolorem quod illo rerum fuga consequatur sed iste maxime iure mollitia totam eligendi. Nam aperiam dolorem inventore recusandae provident id exercitationem magnam nihil ex sit, omnis facilis odit voluptatem doloribus temporibus expedita consequatur eaque iusto ut eveniet placeat. Rerum doloribus commodi, voluptate quo totam hic tempora cumque distinctio rem error magni eveniet. Reiciendis nihil dolorem qui, earum, nisi iusto accusamus libero eos quia illo, at beatae in repudiandae adipisci nam possimus reprehenderit consequuntur dolorum?', 8, '2023-01-31 10:32:36'),
(23, 'salut comment ca ce passe ici bien les copains ?', 10, '2023-01-31 14:07:08'),
(21, 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 8, '2023-01-31 10:32:51'),
(22, 'salut juis nouveau les copains !', 9, '2023-01-31 10:56:26');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`, `avatar`) VALUES
(9, 'red', 'red', '9.png'),
(8, 'admin', 'admin', '8.png'),
(10, 'dropz', 'dropz', '10.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
