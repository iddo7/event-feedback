-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 14 Septembre 2023 à 21:44
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `event-feedback`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(350) NOT NULL,
  `dateStart` date NOT NULL,
  `dateEnd` date NOT NULL,
  `img` varchar(1060) NOT NULL,
  `departementId` int(11) NOT NULL,
  `votesGreen` int(11) NOT NULL,
  `votesYellow` int(11) NOT NULL,
  `votesRed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Contenu de la table `events`
--

INSERT INTO `events` (`id`, `name`, `dateStart`, `dateEnd`, `img`, `departementId`, `votesGreen`, `votesYellow`, `votesRed`) VALUES
(1, 'Iniciation', '2023-09-15', '2023-09-16', 'https://m1.quebecormedia.com/emp/emp/Local_3f8748371-5fcc-4462-a59f-c715bd1848c6_ORIGINAL.jpg?impolicy=crop-resize&x=0&y=51&w=1373&h=566&width=1200', 1, 5, 12, 0);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
