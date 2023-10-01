-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 01 Octobre 2023 à 22:06
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `event_feedback`
--

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Contenu de la table `departements`
--

INSERT INTO `departements` (`id`, `name`, `description`) VALUES
(1, 'Informatique', 'aaaaa'),
(3, 'Police', 'bbbbb');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(350) NOT NULL,
  `place` varchar(150) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `img` varchar(1060) NOT NULL,
  `departementId` int(11) NOT NULL,
  `studentVotesGreen` int(11) NOT NULL DEFAULT '0',
  `studentVotesYellow` int(11) NOT NULL DEFAULT '0',
  `studentVotesRed` int(11) NOT NULL DEFAULT '0',
  `professionalVotesGreen` int(11) NOT NULL DEFAULT '0',
  `professionalVotesYellow` int(11) NOT NULL DEFAULT '0',
  `professionalVotesRed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Contenu de la table `events`
--

INSERT INTO `events` (`id`, `name`, `place`, `description`, `date`, `img`, `departementId`, `studentVotesGreen`, `studentVotesYellow`, `studentVotesRed`, `professionalVotesGreen`, `professionalVotesYellow`, `professionalVotesRed`) VALUES
(1, 'IniciationAA', '123 rue courval', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sed libero enim sed faucibus turpis in eu. Id aliquet lectus proin nibh nisl condimentum id venenatis a. Iaculis eu non diam phasellus vestibulum lorem sed.', '2023-09-15', 'https://m1.quebecormedia.com/emp/emp/Local_3f8748371-5fcc-4462-a59f-c715bd1848c6_ORIGINAL.jpg?impolicy=crop-resize&amp;x=0&amp;y=51&amp;w=1373&amp;h=566&amp;width=1200', 1, 6, 2, 1, 3, 1, 0),
(2, 'Test', '456 rue marie soleil', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sed libero enim sed faucibus turpis in eu. Id aliquet lectus proin nibh nisl condimentum id venenatis a. Iaculis eu non diam phasellus vestibulum lorem sed.', '2023-09-13', 'https://2.bp.blogspot.com/-Z3G-lfuvwUo/VoZunqSaG-I/AAAAAAAAELQ/ozqewCxm-Wk/s1600/Do%2Bnot%2Bfull%2Byour%2Bclass%2Bas%2Blook%2Blike%2Ba%2BShoping%2BCenter.%2B4.jpg', 3, 0, 0, 0, 5, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `ip` varchar(128) DEFAULT NULL,
  `clientName` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `ip`, `clientName`) VALUES
(1, 'isaacnegreiros10@gmail.com', '8b6d83b524294f8226e2a010c25862eb', '', ''),
(2, 'julienfortin05@gmail.com', '9107ac231a136da5bf352c74abbefdb8', '', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departementId` (`departementId`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`departementId`) REFERENCES `departements` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
