-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 14 Avril 2014 à 20:33
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(12, 'Général', 'Tout ce qui ne va pas ailleurs'),
(13, 'Humour', 'Tout ce qui fait rire'),
(14, 'Cinéma', 'Tout ce qui concerne le 7ème art'),
(15, 'Politique', 'Rouge ou bleu marine ?'),
(16, 'Littérature', 'BHL ou Victor Hugo ?'),
(17, 'Sport', 'Est-ce que tu portes ?'),
(18, 'Sexe', 'Est-ce assez long ? '),
(19, 'Jeux Vidéo', 'Call of Duty, Minecraft et compagnie...'),
(20, 'Santé', 'H5N1, H1N1, HINHIN');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `content`, `date`, `last_edit`, `user_id`, `topic_id`, `is_answer`) VALUES
(1, '42 pour pas être un pigeon, esgi pour youtube.', '2014-04-14 16:51:36', '2014-04-14 16:51:49', 28, 52, 0),
(2, '1. Coupe un doigt de chaque\n2. Donne le doigt de l&#039;un à l&#039;autre\n3. Le premier qui finit le doigt à le droit de manger l&#039;autre en entier', '2014-04-14 16:53:12', NULL, 28, 37, 0),
(3, 'C&#039;est dur dur d&#039;être un bébé', '2014-04-14 16:54:05', NULL, 28, 50, 0),
(4, 'Moi en tout cas je suis.', '2014-04-14 16:54:32', NULL, 27, 50, 0),
(5, 'On a qu&#039;à en faire un film', '2014-04-14 16:55:00', NULL, 28, 54, 0),
(6, 'Dumbledore', '2014-04-14 16:55:50', NULL, 28, 48, 1),
(7, 'Je vais jouer aux Pogs.', '2014-04-14 16:57:01', NULL, 33, 41, 0),
(8, 'J&#039;inventerais un jeu ou les blocs sont en 3d et cassables', '2014-04-14 16:57:40', NULL, 30, 56, 0),
(9, '[quote=Teybeo]\n42 pour pas être un pigeon, esgi pour youtube.\n[/quote]\nC koi l&#039;ESGI ?!\n', '2014-04-14 16:57:54', NULL, 33, 52, 0),
(10, 'Pensez un prendre un bouchon de champagne en cas d&#039;intrusion', '2014-04-14 16:59:02', NULL, 30, 53, 0),
(11, 'Kristen Stewart, pour les moments de solitude, de grand vide, de détresse...', '2014-04-14 16:59:45', NULL, 29, 54, 0),
(12, 'Mange le bébé.', '2014-04-14 16:59:51', NULL, 33, 37, 0),
(13, 'Kev Adams, il et tro bô.', '2014-04-14 17:00:38', NULL, 33, 54, 0),
(14, '[b]L&#039;ESGI[/b] ils ont des micro-ondes et de la wifi (des fois).', '2014-04-14 17:00:54', NULL, 27, 52, 0),
(15, 'Je vais me faire des crêpes.', '2014-04-14 17:01:01', NULL, 30, 41, 0),
(16, '3 épisodes d&#039;Inspecteur Derrick, ça passe tranquille', '2014-04-14 17:01:20', '2014-04-14 17:14:01', 29, 41, 0),
(17, 'Je recrache ma [b]biscotte[/b].', '2014-04-14 17:01:23', '2014-04-14 17:05:52', 33, 51, 0),
(18, 'www.facebook.fr', '2014-04-14 17:01:32', NULL, 30, 47, 0),
(19, '[quote]alors que vous étiez un geek puant.[/quote]\nMais heuuu...', '2014-04-14 17:01:50', NULL, 27, 57, 0),
(20, 'J&#039;achète NBA 2k14, 39€99 sur Steam', '2014-04-14 17:02:11', NULL, 29, 57, 0),
(21, 'Ping-pong, rien que le nom quoi...', '2014-04-14 17:02:33', NULL, 30, 39, 0),
(22, 'Kev Adams il est bien aussi je trouve', '2014-04-14 17:02:53', NULL, 27, 48, 0),
(23, 'It&#039;s a me, Mario !', '2014-04-14 17:03:08', NULL, 30, 49, 0),
(24, 'Candy Crush Saga sera forcément (ré)inventé donc osef', '2014-04-14 17:03:23', NULL, 27, 56, 0),
(25, 'Je revends immédiat notre maison de campagne dans le Nord.', '2014-04-14 17:04:28', NULL, 30, 51, 0),
(26, 'Ca dépend, il est quelle heure ?', '2014-04-14 17:04:39', NULL, 35, 51, 0),
(27, 'Naruto Tome 72. [b]UN BEST-SELLER[/b]', '2014-04-14 17:04:42', NULL, 29, 38, 0),
(28, 'Moi j&#039;aime bien Cheminade, Mars c&#039;est cool.', '2014-04-14 17:05:18', NULL, 27, 40, 0),
(29, '[quote=Teybeo]\nOn a qu&#039;à en faire un film\n[/quote]\nAvec [i]John Malkovich[/i] ?', '2014-04-14 17:06:04', '2014-04-14 17:06:24', 27, 54, 0),
(30, 'Un pour Président, l&#039;autre Premier Ministre\n[b]Vive la France ![/b]', '2014-04-14 17:07:08', NULL, 29, 40, 0),
(31, 'Avortement tardif, la seule solution.', '2014-04-14 17:07:24', NULL, 27, 51, 1),
(32, '[b][i]ou[/i][/b]', '2014-04-14 17:07:29', NULL, 33, 50, 0),
(33, 'Laisse le vivre et porter le patrimoine français jusqu&#039;à sa dernière heure.', '2014-04-14 17:09:30', NULL, 29, 51, 0),
(34, 'C&#039;est pour le boulot ?', '2014-04-14 17:10:17', NULL, 35, 53, 0),
(35, 'Une tablette Surface stp2', '2014-04-14 17:10:40', '2014-04-14 17:35:57', 29, 58, 0),
(36, 'Moi je suis un bonhomme, je prend les livres.', '2014-04-14 17:11:21', NULL, 35, 58, 0),
(37, '[quote=Vuzi]\n[b]L&#039;ESGI[/b] ils ont des micro-ondes et de la wifi (des fois).\n[/quote]\n\nC koi de la wifi ?!', '2014-04-14 17:12:08', NULL, 29, 52, 0),
(38, '[quote=TicTacTaw]\nLaisse le vivre et porter ce qu&#039;il reste du patrimoine français jusqu&#039;à sa dernière heure.\n[/quote]\n*fixed', '2014-04-14 17:12:47', NULL, 27, 51, 0),
(39, 'Moi les livres, je les brûle.', '2014-04-14 17:14:54', NULL, 27, 58, 0),
(40, '+1 pour facebook', '2014-04-14 17:15:16', NULL, 27, 47, 0),
(41, 'Je reviens tout juste de youPron... Je n&#039;ai pas eu de soucis :/', '2014-04-14 17:16:12', NULL, 35, 47, 0),
(42, 'Surement pour parler du trou de la sécu', '2014-04-14 17:16:26', NULL, 34, 53, 0),
(43, 'Qu&#039;est-ce qu&#039;elle ne veut pas avaler ?', '2014-04-14 17:16:35', NULL, 30, 59, 0),
(44, 'Fait la dormir, et hop !', '2014-04-14 17:16:40', NULL, 27, 59, 0),
(45, 'T&#039;as déjà pensé à la perfusion ?', '2014-04-14 17:17:03', NULL, 29, 59, 1),
(46, '[quote=Guiks]\nQu&#039;est-ce qu&#039;elle ne veut pas avaler ?\n[/quote]\nBah mon jus :o', '2014-04-14 17:18:30', NULL, 35, 59, 0),
(47, '[quote=TicTacTaw]\nT&#039;as déjà pensé à la perfusion ?\n[/quote]\n\nExcellente idée. Merci :)\nça à marché!', '2014-04-14 17:19:33', NULL, 35, 59, 0),
(48, 'Moi j&#039;ai un technique: mange plein de fraises tagada ça lui plaira peut être mieux.', '2014-04-14 17:21:37', NULL, 33, 59, 0),
(49, 'Les livres c&#039;est meiux', '2014-04-14 17:35:31', NULL, 29, 58, 0),
(50, '[quote=Vuzi]\nMoi les livres, je les brûle.\n[/quote]\n[b]la[/b]\n', '2014-04-14 17:36:51', NULL, 29, 58, 0),
(51, 'test', '2014-04-14 17:40:27', NULL, 27, 60, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=61 ;

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
(48, 'Nouvel acteur pour Expendables 4', 'Quel acteur voudriez-vous voir apparaître dans ce chef d''oeuvre ?', '2014-03-30 17:25:39', 35, 14, 1, 0, 0),
(49, 'Mario ou Sonic ?', 'Nintendo ou Sega. Votre choix décidera de la faillite d&#039;un des deux.', '2014-04-14 16:35:54', 30, 19, 0, 510, 0),
(50, 'Etre ou ne pas être ?', 'Lol', '2014-04-14 16:37:07', 30, 14, 0, 120, 0),
(51, 'Votre fils veut devenir le sosie de Patrick Timsit', 'Comme ça, il vous l&#039;annonce sans ménagement au petit-déjeuner.\nQue feriez-vous ?', '2014-04-13 16:38:10', 30, 14, 1, 0, 0),
(52, 'Une école d&#039;informatique', 'On vous propose d&#039;intégrer plusieurs écoles. Laquelle choisissez-vous ?', '2014-04-14 16:42:12', 30, 12, 0, 42, 0),
(53, 'RDV avec DSK', 'DSK vous appelle pour un rencard le soir même dans un Sofitel.', '2014-04-14 16:50:11', 34, 15, 0, 69, 0),
(54, 'Etre dans la tête d&#039;un acteur', 'Vivre une journée dans la tête de l&#039;acteur de votre choix. (Sauf John Malkovich évidemment)', '2014-04-14 16:51:31', 34, 14, 0, 0, 0),
(55, 'Transformation en Kev Adams', 'Mon fils vient de se réveiller et il a la tête ET l&#039;humour de Kev Adams.\nJe l&#039;abats tout de suite ou ...', '2014-04-14 16:52:42', 34, 13, 0, 13, 0),
(56, 'Et si Tetris n&#039;existait pas ?', 'Que feriez-vous ?', '2014-04-14 16:54:37', 33, 19, 0, 5, 0),
(57, 'Réveil en M. Jordan', 'Vous devenez subitement une star du basket, alors que vous étiez un geek puant.', '2014-04-14 16:56:04', 33, 17, 0, 84, 0),
(58, '10 livres ou liseuse et 1 ebook ?', 'Fnac fait une offre pour 10 ans d&#039;adhésion, 10 livres gratuits ou une liseuse Kobo Aura HD et 1 ebook offert ?', '2014-04-14 17:09:29', 34, 16, 0, 0, 0),
(59, 'Elle ne veut pas avaler.', 'Même quand je l&#039;attache.\nJ&#039;ai tout essayé. Que faire ?', '2014-04-14 17:15:43', 35, 18, 1, 0, 0),
(60, 'Question', 'Contenu', '2014-04-14 17:39:59', 29, 13, 1, 200, 0);

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
(27, 'Vuzi', 'vuzi@vouzi.fr', 'password', 'Guillaume', 'Villerez', 60, 3200, 10, 1, 1, 0),
(28, 'Teybeo', 'teybeo@caramail.fr', 'password', 'Thibault', 'D''Archivio', 60, 38, 9000, 1, 1, 0),
(29, 'TicTacTaw', 'tic@tac.taw', 'password', 'Thibault', 'Crosnier', 60, 8800, 5, 1, 1, 0),
(30, 'Guiks', 'guiks@gks.fr', 'password', 'Guillaume', 'Delapré', 60, 5328, 42, 1, 1, 0),
(31, 'Boulebizarre', 'boulbi@poke.com', 'password', 'Eric', 'Pepperoni', 55, 200, 0, 0, 0, 0),
(32, 'Saran', 'saran@hasnor.fr', 'password', 'Thomas', 'Azoug', 57, 400, 7, 0, 0, 0),
(33, 'Bart917', 'bart@hotmail.fr', 'password', 'Alexandre', 'Rivet', 35, 451, 15, 0, 0, 0),
(34, 'Rayto', 'rayto@live.fr', 'password', 'Maxime', 'Helaine', 42, 18, 2, 0, 0, 0),
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `vote`
--

INSERT INTO `vote` (`id`, `post_id`, `user_id`, `value`) VALUES
(1, 1, 33, 1),
(2, 8, 30, 10),
(3, 1, 30, 1),
(4, 2, 33, 1),
(5, 9, 27, -1),
(6, 9, 30, -1),
(7, 5, 29, 1),
(8, 7, 30, 1),
(9, 5, 33, 1),
(10, 11, 33, -8),
(11, 1, 27, 1),
(12, 14, 27, 1),
(13, 13, 27, 1),
(14, 11, 27, -1),
(15, 11, 30, -1),
(16, 13, 30, 1),
(17, 29, 27, 5),
(18, 11, 29, 1),
(19, 10, 35, 1),
(20, 31, 34, 3),
(21, 17, 34, -1),
(22, 16, 29, 1),
(23, 15, 29, -1),
(24, 35, 34, -1),
(25, 18, 34, 1),
(26, 18, 27, 1),
(27, 44, 27, 2),
(28, 43, 27, -1),
(29, 46, 30, 1),
(30, 45, 30, 1),
(31, 44, 30, 1),
(32, 35, 29, -1),
(33, 36, 29, 1);

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
