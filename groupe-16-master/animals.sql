-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql-etu.unicaen.fr:3306
-- Généré le : mar. 18 fév. 2025 à 01:22
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1-log
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `diallo2210_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `name`, `species`, `age`, `image_path`) VALUES
(7, 'snop', 'dog', 34, 'uploads/chien.jpeg'),
(14, 'gyuig', 'yguygiuy', 55, './uploads/6751acfa7d9bdchien.jpeg'),
(15, 'uyguyg', 'yuguyg', 88, 'uploads/6751ad52686d3chien.jpeg'),
(16, 'uygyggh', 'uihiuhgiu', 99, 'uploads/6751ada1e0ad1chien2.jpeg'),
(17, 'aaz', 'arar', 23, 'uploads/6751adc40105cchien2.jpeg'),
(18, 'yfkh', 'ykfh', 2, 'uploads/6751bc1752f98chien.jpeg'),
(19, '<script>alert(\"test\")</script>', 'khvk', 45, 'uploads/6751bd968314cchien.jpeg'),
(20, 'uikgvkj', 'gfuyj', 3, 'uploads/6751c96362d7echien.jpeg'),
(21, 'oui', 'oui', 1, 'uploads/67541c420cb35pngtree-gray-network-placeholder-png-image_3416659.jpg'),
(22, 'oui', 'oui', 1, 'uploads/67541c8c56aadpngtree-gray-network-placeholder-png-image_3416659.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
