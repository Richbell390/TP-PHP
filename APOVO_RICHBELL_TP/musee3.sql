-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 05 Août 2020 à 20:30
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `musee3`
--

-- --------------------------------------------------------

--
-- Structure de la table `bibliotheque`
--

CREATE TABLE IF NOT EXISTS `bibliotheque` (
  `numMus` int(11) NOT NULL DEFAULT '0',
  `ISBN` varchar(255) NOT NULL DEFAULT '',
  `dateAchat` date DEFAULT NULL,
  PRIMARY KEY (`numMus`,`ISBN`),
  KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bibliotheque`
--

INSERT INTO `bibliotheque` (`numMus`, `ISBN`, `dateAchat`) VALUES
(17, '23-98-08-76-543 ', '2020-05-09'),
(18, '243-6567-09765 ', '2020-07-09');

-- --------------------------------------------------------

--
-- Structure de la table `moment`
--

CREATE TABLE IF NOT EXISTS `moment` (
  `jour` date NOT NULL,
  PRIMARY KEY (`jour`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `moment`
--

INSERT INTO `moment` (`jour`) VALUES
('2020-05-21'),
('2020-06-01'),
('2020-06-26'),
('2020-08-02'),
('2020-08-03');

-- --------------------------------------------------------

--
-- Structure de la table `musee`
--

CREATE TABLE IF NOT EXISTS `musee` (
  `numMus` int(11) NOT NULL AUTO_INCREMENT,
  `nomMus` varchar(250) DEFAULT NULL,
  `nblivres` int(11) NOT NULL,
  `codePays` int(11) DEFAULT NULL,
  PRIMARY KEY (`numMus`),
  KEY `codePays` (`codePays`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `musee`
--

INSERT INTO `musee` (`numMus`, `nomMus`, `nblivres`, `codePays`) VALUES
(16, 'StoreMusee', 23, 229),
(17, 'Science', 43, 221),
(18, 'Le MusÃ©e', 45, 225),
(19, 'London MusÃ©e', 456, 226),
(20, 'Graphisme MusÃ©e', 21, 228);

-- --------------------------------------------------------

--
-- Structure de la table `ouvrage`
--

CREATE TABLE IF NOT EXISTS `ouvrage` (
  `ISBN` varchar(255) NOT NULL,
  `nbPage` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `codePays` int(11) DEFAULT NULL,
  PRIMARY KEY (`ISBN`),
  KEY `codePays` (`codePays`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ouvrage`
--

INSERT INTO `ouvrage` (`ISBN`, `nbPage`, `titre`, `codePays`) VALUES
('23-98-08-76-543', 23, 'Lotus', 226),
('243-6567-09765', 765, 'La nation', 228),
('87-96-99-54', 54, 'bonjour', 225);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `codePays` int(11) NOT NULL,
  `nbhabitant` int(11) NOT NULL,
  PRIMARY KEY (`codePays`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `pays`
--

INSERT INTO `pays` (`codePays`, `nbhabitant`) VALUES
(221, 999333),
(223, 2987653),
(225, 9876543),
(226, 998765435),
(228, 3453769),
(229, 299299);

-- --------------------------------------------------------

--
-- Structure de la table `referencer`
--

CREATE TABLE IF NOT EXISTS `referencer` (
  `nomSite` varchar(255) NOT NULL DEFAULT '',
  `numeroPage` int(11) NOT NULL DEFAULT '0',
  `ISBN` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`nomSite`,`ISBN`,`numeroPage`),
  KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `referencer`
--

INSERT INTO `referencer` (`nomSite`, `numeroPage`, `ISBN`) VALUES
('Saturne ', 54, '243-6567-09765 ');

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `nomSite` varchar(255) NOT NULL,
  `anneedecouv` int(11) DEFAULT NULL,
  `codePays` int(11) DEFAULT NULL,
  PRIMARY KEY (`nomSite`),
  UNIQUE KEY `codePays` (`codePays`),
  KEY `codePays_2` (`codePays`),
  KEY `codePays_3` (`codePays`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `site`
--

INSERT INTO `site` (`nomSite`, `anneedecouv`, `codePays`) VALUES
('Saturne', 2002, 229);

-- --------------------------------------------------------

--
-- Structure de la table `visiter`
--

CREATE TABLE IF NOT EXISTS `visiter` (
  `numMus` int(11) NOT NULL AUTO_INCREMENT,
  `jour` date NOT NULL,
  `nbvisiteurs` int(11) DEFAULT NULL,
  PRIMARY KEY (`numMus`,`jour`),
  KEY `jour` (`jour`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `visiter`
--

INSERT INTO `visiter` (`numMus`, `jour`, `nbvisiteurs`) VALUES
(16, '2020-05-21', 1),
(17, '2020-06-01', 54),
(19, '2020-08-03', 5);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `bibliotheque`
--
ALTER TABLE `bibliotheque`
  ADD CONSTRAINT `bibliotheque_ibfk_1` FOREIGN KEY (`numMus`) REFERENCES `musee` (`numMus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bibliotheque_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `ouvrage` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `musee`
--
ALTER TABLE `musee`
  ADD CONSTRAINT `musee_ibfk_1` FOREIGN KEY (`codePays`) REFERENCES `pays` (`codePays`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ouvrage`
--
ALTER TABLE `ouvrage`
  ADD CONSTRAINT `ouvrage_ibfk_1` FOREIGN KEY (`codePays`) REFERENCES `pays` (`codePays`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `referencer`
--
ALTER TABLE `referencer`
  ADD CONSTRAINT `referencer_ibfk_1` FOREIGN KEY (`nomSite`) REFERENCES `site` (`nomSite`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `referencer_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `ouvrage` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `site_ibfk_1` FOREIGN KEY (`codePays`) REFERENCES `pays` (`codePays`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `visiter`
--
ALTER TABLE `visiter`
  ADD CONSTRAINT `visiter_ibfk_1` FOREIGN KEY (`numMus`) REFERENCES `musee` (`numMus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visiter_ibfk_2` FOREIGN KEY (`jour`) REFERENCES `moment` (`jour`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
