-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 14 Avril 2014 à 14:43
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
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(12, 'Général', ''),
(13, 'Humour', ''),
(14, 'Cinéma', ''),
(15, 'Politique', ''),
(16, 'Littérature', ''),
(17, 'Sport', ''),
(18, 'Sexe', ''),
(19, 'Jeux Vidéo', '');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `last_edit` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `is_answer` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=61 ;

--
-- Contenu de la table `rank`
--

INSERT INTO `rank` (`id`, `name`) VALUES
(31, 'Voyageur'),
(32, 'Explorateur'),
(33, 'Conteur'),
(34, 'Palefrenier'),
(35, 'Page'),
(36, 'Ecuyer'),
(37, 'Damoiseau'),
(38, 'Chevalier'),
(39, 'Champion'),
(40, 'Seigneur'),
(41, 'Banneret'),
(42, 'Baron'),
(43, 'Vicomte'),
(44, 'Comte'),
(45, 'Marquis'),
(46, 'Duc'),
(47, 'Prince'),
(48, 'Dauphin'),
(49, 'Roi'),
(50, 'Empereur'),
(51, 'Héros'),
(52, 'Légende'),
(53, 'Prophète'),
(54, 'Oracle'),
(55, 'Immortel'),
(56, 'Ange'),
(57, 'Archange'),
(58, 'Demi-Dieu'),
(59, 'Dieu'),
(60, 'Alpha & Oméga');

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `answered` tinyint(1) NOT NULL DEFAULT '0',
  `pot_point` int(11) NOT NULL,
  `pot_euro` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=53 ;

--
-- Contenu de la table `topic`
--

INSERT INTO `topic` (`id`, `title`, `content`, `date`, `user_id`, `category_id`, `answered`, `pot_point`, `pot_euro`) VALUES
(37, 'Un bébé et un chat à nourrir', 'J''ai plus rien dans le frigo et ces eux bestioles meurent de faim. Laquelle dois-je nourrir en premier ?', '2014-04-10 09:27:12', 27, 13, 0, 100, 3),
(38, 'Stephen King ou Harlan Coben ?', 'Grâce à mon abonnement France Loisirs, je peux obtenir un livre gratuitement. J''hésite entre le dernier Stephen King et le dernier Harlan Coben. ', '2014-04-01 10:14:44', 28, 16, 0, 342, 1),
(39, 'Sport de paresseux', 'Un bon sport de flemmard please.', '2014-03-13 04:26:42', 29, 17, 0, 10, 2),
(40, 'Pour qui voter ?', 'A cause de leur programme très proche, j''hésite entre Marine Le Pen et Jean-Luc Mélenchon. Que faire ?', '2014-03-17 12:23:44', 30, 15, 0, 45, 0),
(41, 'Plus qu''une heure à vivre', 'Question plutôt classique, que feriez-vous ?', '2014-04-02 15:20:31', 31, 12, 0, 45, 9),
(47, 'Les sites pornos deviennent illégaux...', '... mais vous pouvez garder accès à un seul d''entre eux. Lequel choisissez-vous ?', '2014-04-02 11:17:46', 32, 18, 0, 10, 0),
(48, 'Nouvel acteur pour Expendables 4', 'Quel acteur voudriez-vous voir apparaître dans ce chef d''oeuvre ?', '2014-03-30 17:25:39', 35, 14, 0, 0, 0),
(49, 'Mario ou Sonic ?', 'Nintendo ou Sega. Votre choix décidera de la faillite d&#039;un des deux.', '2014-04-14 16:35:54', 30, 19, 0, 510, 0),
(50, 'Etre ou ne pas être ?', 'Lol', '2014-04-14 16:37:07', 30, 14, 0, 120, 0),
(51, 'Votre fils veut devenir le sosie de Patrick Timsit', 'Comme ça, il vous l&#039;annonce sans ménagement au petit-déjeuner.\nQue feriez-vous ?', '2014-04-14 16:38:10', 30, 14, 0, 0, 0),
(52, 'Une école d&#039;informatique', 'On vous propose d&#039;intégrer plusieurs écoles. Laquelle choisissez-vous ?', '2014-04-14 16:42:12', 30, 12, 0, 42, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_bin NOT NULL,
  `mail` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `first_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `rank_id` int(50) NOT NULL,
  `nb_point` int(11) NOT NULL,
  `nb_euro` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `premium` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rank` (`rank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `mail`, `password`, `first_name`, `last_name`, `rank_id`, `nb_point`, `nb_euro`, `admin`, `premium`, `banned`) VALUES
(27, 'Vuzi', 'vuzi@vouzi.fr', 'password', 'Guillaume', 'Villerez', 60, 3000, 10, 1, 1, 0),
(28, 'Teybeo', 'teybeo@caramail.fr', 'password', 'Thibault', 'D''Archivio', 60, 38, 9000, 1, 1, 0),
(29, 'TicTacTaw', 'tic@tac.taw', 'password', 'Thibault', 'Crosnier', 60, 9000, 5, 1, 1, 0),
(30, 'Guiks', 'guiks@gks.fr', 'password', 'Guillaume', 'Delapré', 60, 5328, 42, 1, 1, 0),
(31, 'Boulebizarre', 'boulbi@poke.com', 'password', 'Eric', 'Pepperoni', 55, 200, 0, 0, 0, 0),
(32, 'Saran', 'saran@hasnor.fr', 'password', 'Thomas', 'Azoug', 57, 400, 7, 0, 0, 0),
(33, 'Bart917', 'bart@hotmail.fr', 'password', 'Alexandre', 'Rivet', 35, 540, 15, 0, 0, 0),
(34, 'Rayto', 'rayto@live.fr', 'password', 'Maxime', 'Helaine', 42, 100, 2, 0, 0, 0),
(35, 'Que20', 'queque20@lol.fr', 'password', 'Kévin', 'Maarek', 51, 500, 6300, 0, 0, 0),
(36, 'Supnude', 'sup@nude.fr', 'password', 'Martin', 'Troll', 31, 0, 0, 0, 0, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
