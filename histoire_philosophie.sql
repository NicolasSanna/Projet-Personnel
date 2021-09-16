-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 14 juin 2021 à 08:27
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `histoire_philosophie`
--
CREATE DATABASE IF NOT EXISTS `histoire_philosophie` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `histoire_philosophie`;

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `SP_ArticleCategorieListeLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ArticleCategorieListeLire` (IN `cat_id` INT)  BEGIN
    SELECT * 
    FROM article art
    INNER JOIN categorie cat ON art.id_cat = cat.id_cat
    WHERE art.id_cat = cat_id
    ORDER BY art.date_creation_article DESC;
END$$

DROP PROCEDURE IF EXISTS `SP_ArticleLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ArticleLire` (`art_id` INT)  BEGIN
    SELECT * 
    FROM article art 
    WHERE art.id_art = art_id
    ORDER BY art.date_creation_article DESC;
END$$

DROP PROCEDURE IF EXISTS `SP_ArticleListeLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ArticleListeLire` ()  BEGIN
    SELECT * 
    FROM article art 
    ORDER BY art.date_creation_article DESC;
END$$

DROP PROCEDURE IF EXISTS `SP_ArticlesLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ArticlesLire` ()  BEGIN
    SELECT * 
    FROM article art 
    ORDER BY art.date_creation_article DESC;
END$$

DROP PROCEDURE IF EXISTS `SP_CategorieListeLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CategorieListeLire` ()  BEGIN
    SELECT * 
    FROM categorie cat 
    ORDER BY cat.id_cat ASC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_art` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_article` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `id_aut` int(10) UNSIGNED NOT NULL,
  `id_cat` int(10) UNSIGNED NOT NULL,
  `date_creation_article` datetime DEFAULT NULL,
  `date_modification_article` datetime DEFAULT NULL,
  PRIMARY KEY (`id_art`),
  KEY `fk_art_auteur` (`id_aut`),
  KEY `fk_art_categorie` (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_art`, `nom_article`, `contenu`, `id_aut`, `id_cat`, `date_creation_article`, `date_modification_article`) VALUES
(1, 'La République de Platon', 'La République (en grec Περὶ πολιτείας / Perì politeías, « à propos de l\'État / de la Cité » ou Πολιτεία / politeía, « la constitution ») est un des dialogues de Platon portant principalement sur la justice dans l\'individu et dans la Cité. On considère ce dialogue comme faisant partie intégrante du genre littéraire utopique\r\n\r\nPlaton fait la critique de la démocratie dans sa dégénérescence en démagogie et en tyrannie à cause de l\'attrait qu\'exerce le prestige du pouvoir. Il s\'agit de l\'ouvrage le plus connu et le plus célèbre de Platon en raison, entre autres, du modèle de vie communautaire exposé et de la théorie des Formes que Platon y expose et défend.', 2, 5, '2021-06-11 00:00:00', '2021-06-11 00:00:00'),
(2, 'L\'Enquête d\'Hérodote', 'Les Histoires ou l\'Enquête (en grec ancien Ἱστορίαι / Historíai) est la seule œuvre connue de l\'historien grec, Hérodote. Le titre signifie littéralement « recherches, enquêtes » (du grec ἵστωρ / histôr, « celui qui sait, qui connaît »). C\'est le plus ancien texte complet en prose que nous ayons conservé de l\'Antiquité1. Hérodote y expose le développement de l\'empire perse, puis y relate les guerres médiques qui opposèrent les Perses aux Grecs.\r\n\r\nLes Histoires ont probablement été rédigées vers 445 av. J.-C., où la tradition de la philosophie antique mentionne qu\'Hérodote fit une lecture publique de son travail à Athènes, pour lequel il reçut une récompense officielle qui se serait élevée à dix talents, une somme considérable. Cependant, la composition de ce texte s\'étala sur plusieurs années, du fait des longs voyages nécessaires à l\'époque pour concrétiser un tel témoignage et de la complexité du propos.', 1, 1, '2021-06-11 00:00:00', '2021-06-11 00:00:00'),
(3, 'La lettre à Ménécée d\'Épicure', 'Épicure (en grec Ἐπίκουρος / Epíkouros) est un philosophe grec, né à la fin de l\'année 342 av. J.-C. ou au début de l\'année 341 av. J.-C. et mort en 270 av. J.-C. Il est le fondateur, en 306 av. J.-C., de l\'épicurisme, l\'une des plus importantes écoles philosophiques de l\'Antiquité. En physique, il soutient comme Démocrite que tout ce qui existe est composé d\'atomes indivisibles. Les atomes se meuvent aléatoirement dans le vide et peuvent se combiner pour former des agrégats de matière. L\'âme en particulier serait un de ces agrégats d\'atomes, et non une entité spirituelle, notamment d\'après son disciple Lucrèce. En éthique, le philosophe grec défend l\'idée que le souverain bien est le plaisir, passant avant toute chose par l\'« absence de douleur » (voir l\'article Ataraxie). En logique ou épistémologie, Épicure considère que la sensation est à l\'origine de toute connaissance et annonce ainsi l\'empirisme.\r\n\r\nÉpicure fut un auteur extrêmement prolifique, Diogène Laërce, biographe tardif et principale source sur sa vie, cite au moins trois cents écrits, mais seuls quelques fragments et des abrégés, ses Lettres, ont subsisté.', 5, 5, '2021-06-11 00:00:00', '2021-06-11 00:00:00'),
(4, 'Histoire de Rome depuis sa fondation de Tite-Live', 'L\'Histoire de Rome depuis sa fondation (en latin Ab Urbe condita libri, littéralement « les livres depuis la fondation de la Ville » [Urbs, la Ville est toujours Rome]) est une œuvre de l\'historien Tite-Live dont il entame la rédaction aux alentours de 31 av. J.-C. De cette œuvre immense qui couvre en 142 livres, des origines de Rome jusqu\'à la mort de Drusus en 9 av. J.-C., seul le quart, soit trente-cinq livres, nous est parvenu, le reste est connu par des abrégés.\r\n\r\nCette œuvre est organisée en groupes de 10 livres (parfois en groupes de 5), traditionnellement nommés « décades » au Moyen Âge, terme que Tite-Live n\'emploie jamais et qui n\'est attesté qu\'à partir de 496, par une lettre du pape Gélase Ier. Il est possible que ce regroupement soit motivé par des raisons d\'édition, lorsque les copistes ont substitué la présentation en codex groupant plusieurs livres aux séries de volumen d\'un livre chacun.\r\n\r\nLes livres qui sont restés concernent l\'histoire des premiers siècles de Rome depuis sa fondation jusqu\'en 292 av. J.-C., puis, dans les troisième, quatrième et cinquième décades, le récit de la deuxième guerre punique et de la conquête par les armes romaines de la Gaule cisalpine, de la Grèce, de la Macédoine, et d\'une partie de l\'Asie Mineure. Le dernier événement important qui s\'y trouve relaté est le triomphe de Paul Émile à Pydna en 168 av. J.-C.7.', 6, 1, '2021-06-10 00:00:00', '2021-06-10 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

DROP TABLE IF EXISTS `auteur`;
CREATE TABLE IF NOT EXISTS `auteur` (
  `id_aut` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `date_creation_compte` datetime NOT NULL,
  PRIMARY KEY (`id_aut`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id_aut`, `pseudo`, `mdp`, `email`, `date_creation_compte`) VALUES
(1, 'Hérodote', 'azertyuiop', 'herodote@blabla.com', '2021-06-11 00:00:00'),
(2, 'Platon', 'azertyuiop', 'platon@blabla.comm', '2021-06-11 00:00:00'),
(5, 'Épicure', 'azertyuiop', 'epicure@blabla.com', '2021-06-11 00:00:00'),
(6, 'Tite-Live', 'azertyuiop', 'titelive@blabla.com', '2021-06-11 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_cat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie` varchar(128) NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `categorie`) VALUES
(1, 'Histoire Antique'),
(2, 'Histoire Médiévale'),
(3, 'Histoire Moderne'),
(4, 'Histoire Contemporaine'),
(5, 'Philosophie Antique'),
(6, 'Philosophie Médiévale'),
(7, 'Philosophie Moderne'),
(8, 'Philosophie Contemporaine');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_com` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_art` int(10) UNSIGNED NOT NULL,
  `id_aut` int(10) UNSIGNED NOT NULL,
  `commentaire` text,
  PRIMARY KEY (`id_com`),
  KEY `fk_com_article` (`id_art`),
  KEY `fk_com_auteur` (`id_aut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_art_auteur` FOREIGN KEY (`id_aut`) REFERENCES `auteur` (`id_aut`),
  ADD CONSTRAINT `fk_art_categorie` FOREIGN KEY (`id_cat`) REFERENCES `categorie` (`id_cat`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_com_article` FOREIGN KEY (`id_art`) REFERENCES `article` (`id_art`),
  ADD CONSTRAINT `fk_com_auteur` FOREIGN KEY (`id_aut`) REFERENCES `auteur` (`id_aut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
