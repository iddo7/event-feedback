-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 02 Octobre 2023 à 16:57
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

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
  `description` varchar(500) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `groupe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Contenu de la table `departements`
--

INSERT INTO `departements` (`id`, `name`, `description`, `type`, `groupe`) VALUES
(1, 'Techniques de génie mécanique', '', 'Technique', 'Ingéniosité'),
(2, 'Techniques de l’informatique', '', 'Technique', 'Ingéniosité'),
(3, 'Technologie de l’architecture', '', 'Technique', 'Ingéniosité'),
(4, 'Technologie de la mécanique du bâtiment (Génie du bâtiment)', '', 'Technique', 'Ingéniosité'),
(5, 'Technologie de la mécanique industrielle (maintenance)', '', 'Technique', 'Ingéniosité'),
(6, 'Technologie du génie civil', '', 'Technique', 'Ingéniosité'),
(7, 'Technologie du génie électrique – Automatisation et contrôle', '', 'Technique', 'Ingéniosité'),
(8, 'Technologie du génie électrique : Électronique programmable', '', 'Technique', 'Ingéniosité'),
(9, 'Technologie du génie industriel', '', 'Technique', 'Ingéniosité'),
(10, 'Technologie du génie métallurgique', '', 'Technique', 'Ingéniosité'),
(11, 'Techniques de design d’intérieur', '', 'Technique', 'Créativité'),
(12, 'Techniques de la documentation', '', 'Technique', 'Curiosité'),
(13, 'Techniques d’hygiène dentaire', '', 'Technique', 'Dévouement'),
(14, 'Techniques de diététique', '', 'Technique', 'Dévouement'),
(15, 'Techniques de soins infirmiers', '', 'Technique', 'Dévouement'),
(16, 'Techniques de soins infirmiers destiné aux infirmières auxiliaires', '', 'Technique', 'Dévouement'),
(17, 'Techniques de travail social', '', 'Technique', 'Dévouement'),
(18, 'Techniques d’éducation à l’enfance', '', 'Technique', 'Dévouement'),
(19, 'Techniques policières', '', 'Technique', 'Dévouement'),
(20, 'DEC-Bac en Logistique', '', 'Technique', 'Leadership'),
(21, 'DEC-Bac en Marketing', '', 'Technique', 'Leadership'),
(22, 'DEC-Bac en Sciences comptables', '', 'Technique', 'Leadership'),
(23, 'Gestion de commerces', '', 'Technique', 'Leadership'),
(24, 'Gestion des opérations et de la chaine logistique', '', 'Technique', 'Leadership'),
(25, 'Techniques de comptabilité et de gestion', '', 'Technique', 'Leadership'),
(26, 'Arts visuels', '', 'Préuniversitaire', 'Créativité'),
(27, 'Arts, lettres et communication – Théâtre et créations médias', '', 'Préuniversitaire', 'Créativité'),
(28, 'Musique', '', 'Préuniversitaire', 'Créativité'),
(29, 'Sciences humaines avec préalables en mathématiques', '', 'Préuniversitaire', 'Leadership'),
(30, 'Arts, lettres et communication – Langues', '', 'Préuniversitaire', 'Curiosité'),
(31, 'Arts, lettres et communication – Littérature, arts et cinéma', '', 'Préuniversitaire', 'Curiosité'),
(32, 'Histoire et civilisation', '', 'Préuniversitaire', 'Curiosité'),
(33, 'Sciences de la nature', '', 'Préuniversitaire', 'Curiosité'),
(34, 'Sciences humaines', '', 'Préuniversitaire', 'Curiosité'),
(35, 'Sciences informatiques et mathématiques', '', 'Préuniversitaire', 'Curiosité'),
(36, 'Sciences, lettres et arts', '', 'Préuniversitaire', 'Curiosité'),
(37, 'DEC-Bac en Soins infirmiers', '', 'DEC-Bac', NULL),
(38, 'DEC-Bac en Documentation', '', 'DEC-Bac', NULL),
(39, 'DEC-Bac en Design d’intérieur', '', 'DEC-Bac', NULL),
(40, 'DEC-Bac en Travail social', '', 'DEC-Bac', NULL),
(41, 'DEC-Bac en Informatique', '', 'DEC-Bac', NULL),
(42, 'Tremplin DEC', '', 'Autre', 'Général');

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
(10, 'Évènement Test 1', '123 rue de marcoux', 'Ceci est un évènement de test', '2023-10-11', 'https://www.bounceu.com/wp-content/uploads/2017/04/BounceU-162.jpg', 10, 13, 5, 25, 16, 6, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `ip` varchar(128) DEFAULT NULL,
  `clientName` varchar(128) DEFAULT NULL,
  `prenom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `ip`, `clientName`, `prenom`) VALUES
(1, 'isaacnegreiros10@gmail.com', '8b6d83b524294f8226e2a010c25862eb', '', '', 'Isaac'),
(2, 'julienfortin05@gmail.com', '9107ac231a136da5bf352c74abbefdb8', NULL, NULL, 'Julien');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
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
