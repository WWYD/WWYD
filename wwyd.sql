-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 07 Mars 2014 à 15:29
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `wwyd`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Humour'),
(2, 'Général'),
(3, 'Politique'),
(4, 'Cinéma'),
(5, 'Littérature'),
(6, 'Jeux Vidéo'),
(7, 'Sport'),
(8, 'Sexe');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `is_answer` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `content`, `date`, `user_id`, `topic_id`, `is_answer`) VALUES
(5, 'Mange le chat et fait souffrir le bébé.', '2014-03-03 08:20:13', 1, 1, 0),
(6, 'Miaou.', '2014-03-04 07:21:35', 2, 1, 0),
(7, 'J''aime les bébés.', '2014-03-05 13:39:03', 3, 1, 0),
(9, 'Ça dépend. C''est pour être femme de ménage ?', '2014-03-07 16:07:49', 2, 23, 1),
(10, 'Elle est où la poulette ?', '2014-03-07 16:09:16', 2, 2, 0),
(11, 'C''est qui qui gagne le plus d''argent ?', '2014-03-07 16:12:15', 2, 24, 0),
(12, 'Sonic, il peut se transformer en Super Saiyan.', '2014-03-07 16:13:12', 2, 25, 0),
(13, 'Essaie de noyer le canard.', '2014-03-07 16:17:24', 2, 3, 0),
(14, 'Essaie de rentrer la catapulte dans l''anus du pigeon ?', '2014-03-07 16:19:09', 3, 2, 0),
(15, 'Je prend les cartes de fidélité, je rend le reste.', '2014-03-07 16:19:56', 3, 4, 0),
(16, 'C''est qui ?', '2014-03-07 16:21:11', 3, 23, 0),
(17, 'L''inverse est pas terrible non plus.', '2014-03-07 16:22:25', 3, 24, 0),
(18, 'Lara Croft.', '2014-03-07 16:23:14', 3, 25, 0),
(19, 'Mange le pigeon, mets-toi dans la catapulte.', '2014-03-07 16:24:46', 4, 2, 0),
(20, 'Il est en cuir ?', '2014-03-07 16:25:58', 4, 4, 0),
(21, 'Kev Adams, il é tro bô', '2014-03-07 16:27:04', 4, 24, 0),
(22, 'Sonic c''est la p*te de Mario pendant les JO non ?', '2014-03-07 16:28:02', 4, 25, 0),
(23, 'Il vibre le canard ?', '2014-03-07 16:28:35', 4, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `rank`
--

INSERT INTO `rank` (`id`, `name`) VALUES
(1, 'Voyageur'),
(2, 'Explorateur'),
(3, 'Conteur'),
(4, 'Palefrenier'),
(5, 'Page'),
(6, 'Ecuyer'),
(7, 'Damoiseau'),
(8, 'Chevalier'),
(9, 'Champion'),
(10, 'Seigneur'),
(11, 'Banneret'),
(12, 'Baron'),
(13, 'Vicomte'),
(14, 'Comte'),
(15, 'Marquis'),
(16, 'Duc'),
(17, 'Prince'),
(18, 'Dauphin'),
(19, 'Roi'),
(20, 'Empereur'),
(21, 'Héros'),
(22, 'Légende'),
(23, 'Prophète'),
(24, 'Oracle'),
(25, 'Immortel'),
(26, 'Ange'),
(27, 'Archange'),
(28, 'Demi-Dieu'),
(29, 'Dieu'),
(30, 'Alpha & Oméga');

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `answered` tinyint(1) NOT NULL DEFAULT '0',
  `pot_point` int(11) NOT NULL,
  `pot_euro` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `topic`
--

INSERT INTO `topic` (`id`, `title`, `content`, `date`, `user_id`, `category_id`, `answered`, `pot_point`, `pot_euro`) VALUES
(1, 'Un bébé, un chat, une portion de nourriture.', 'J''ai un chaton et un bébé à charge, et ils sont tous deux affamés.<br/>\nLe problème, c''est qu''il ne me reste plus qu''une demi-boite de thon et le premier magasin aux alentours est à plusieurs heures de route.<br/>\n<br/>Selon vous, laquelle de ces deux bestioles dois-je nourrir ?', '2014-03-05 00:00:00', 5, 1, 0, 0, 0),
(2, 'Un pigeon, une catapulte.', 'C''est l''histoire d''un pigeon qui souhaitait apprendre à voler.', '2014-03-25 00:00:00', 4, 1, 0, 0, 0),
(3, 'Une baignoire, un canard en plastique.', 'Je m''en remets à vous, je ne sais vraiment pas quoi faire avec ces deux éléments dans ma salle de bain.', '2014-02-11 00:00:00', 3, 8, 0, 0, 0),
(4, 'Un portefeuille trouvé.', 'Problème épineux, dois-je le garder ou non ?', '2014-02-12 00:00:00', 2, 2, 0, 0, 0),
(23, 'Un entretien avec DSK', 'Laisseriez votre fille avoir un entretien d''embauche avec Dominique Strauss-Kahn ?', '2014-01-07 07:39:04', 4, 3, 1, 0, 0),
(24, 'Patrick Timsit ou Kev Adams ?', 'Suite à une visite chez ma voyante préférée, on m''a annoncé que mon fils aurait soit le physique de Patrick Timsit soit l''intelligence de Kev Adams.\r\nJ''ai peur et je ne sais pas ce que je préfèrerais. Qu''en pensez-vous ?', '2014-03-01 12:41:18', 1, 4, 0, 0, 0),
(25, 'Sonic ou Mario ?', 'C''est l''éternel débat qui recommence.', '2014-02-12 10:32:22', 3, 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `rank_id` int(50) NOT NULL,
  `nb_point` int(11) NOT NULL,
  `nb_euro` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rank` (`rank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `mail`, `password`, `first_name`, `last_name`, `rank_id`, `nb_point`, `nb_euro`, `admin`, `premium`) VALUES
(1, 'Teybeo', 'teybeo@swag.fr', 'password', 'Thibault', 'D''Archivio', 30, 9000, 0, 1, 0),
(2, 'Guiks', 'guiks@geek.gks', 'password', 'Guillaume', 'Delapré', 30, 9000, 0, 1, 0),
(3, 'TicTacTaw', 'tic@tac.taw', 'password', 'Thibault', 'Crosnier', 30, 9000, 0, 1, 1),
(4, 'Vuzi', 'vuzi@vouzi.va', 'password', 'Guillaume', 'Villerez', 30, 9000, 0, 1, 1),
(5, 'Supnude', 'troll@boulet.biz', 'password', 'Martin', 'Boulet', 1, 42, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `vote`
--

INSERT INTO `vote` (`id`, `post_id`, `user_id`, `value`) VALUES
(1, 5, 1, -1),
(2, 5, 2, -1),
(3, 5, 3, -1),
(4, 6, 4, -1),
(5, 6, 5, -1),
(6, 5, 1, 1),
(7, 5, 2, 1),
(8, 5, 3, -1),
(9, 6, 4, 1),
(10, 6, 5, 1),
(11, 11, 2, 1),
(12, 10, 3, 1),
(13, 9, 3, 1),
(14, 11, 3, 1),
(15, 12, 3, -1),
(16, 14, 4, 1),
(17, 10, 4, 1),
(18, 15, 4, -1),
(19, 17, 4, 1),
(20, 11, 4, 1),
(21, 12, 4, -1),
(22, 18, 4, 1),
(23, 13, 4, -1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`);

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`rank_id`) REFERENCES `rank` (`id`);

--
-- Contraintes pour la table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `vote_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
