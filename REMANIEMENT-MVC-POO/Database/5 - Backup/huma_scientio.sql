-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 21 nov. 2021 à 10:31
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `huma_scientio`
--
CREATE DATABASE IF NOT EXISTS `huma_scientio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `huma_scientio`;

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `SP_AllArticlesOrderByDateSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllArticlesOrderByDateSelect` ()  BEGIN

    SELECT art.id, art.title, art.content, art.user_id, art.category_id, art.creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    ORDER BY art.creation_date DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_AllCategoriesForArticleSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllCategoriesForArticleSelect` ()  BEGIN

    SELECT *
    FROM categories;

END$$

DROP PROCEDURE IF EXISTS `SP_AllCategoriesSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllCategoriesSelect` ()  BEGIN

    SELECT *
    FROM Categories
    WHERE id <> 1
    AND category <> "Non classé";

END$$

DROP PROCEDURE IF EXISTS `SP_AllCommentsArticleSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllCommentsArticleSelect` (`v_article_id` INT(11))  BEGIN

    SELECT com.content, com.date_publication, u.pseudo, com.article_id
    FROM comments com
    INNER JOIN users u ON com.user_id = u.id
    WHERE com.article_id = v_article_id
    AND com.status_id = 2
    ORDER BY date_publication DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_AllCommentsNotApprouvedSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllCommentsNotApprouvedSelect` ()  BEGIN

    SELECT com.id, com.content, com.date_publication, u.pseudo, com.article_id, art.title
    FROM comments com
    INNER JOIN users u ON com.user_id = u.id
    INNER JOIN articles art ON com.article_id = art.id
    WHERE com.status_id = 1
    ORDER BY com.date_publication DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_AllCommentsUpdate`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllCommentsUpdate` ()  BEGIN

    UPDATE comments
    SET status_id = 2
    WHERE status_id = 1;

END$$

DROP PROCEDURE IF EXISTS `SP_AllGrantsSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_AllGrantsSelect` ()  BEGIN

    SELECT *
    FROM grants
    WHERE privilege <> "Administrateur"
    OR id <> 1;

END$$

DROP PROCEDURE IF EXISTS `SP_ArticleDelete`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_ArticleDelete` (`v_article_id` INT, `v_user_id` INT)  BEGIN

    DELETE 
    FROM articles
    WHERE id = v_article_id
    AND user_id = v_user_id;

END$$

DROP PROCEDURE IF EXISTS `SP_ArticleInsert`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_ArticleInsert` (`v_title` VARCHAR(255), `v_content` TEXT, `v_category_id` INT, `v_user_id` INT)  BEGIN

    INSERT INTO articles (title, content, category_id, user_id, creation_date) 
    VALUES (v_title, v_content, v_category_id, v_user_id, NOW());

END$$

DROP PROCEDURE IF EXISTS `SP_ArticlesByCategorySelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_ArticlesByCategorySelect` (`v_category_id` INT)  BEGIN

    SELECT articles.id AS id_article , title, content, user_id, category_id, creation_date, categories.id AS id_category, category, pseudo
    FROM articles
    INNER JOIN categories ON articles.category_id = categories.id
    INNER JOIN users ON articles.user_id = users.id
    WHERE categories.id = v_category_id
    ORDER BY creation_date DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_ArticleSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_ArticleSelect` (`v_id` INT)  BEGIN

    SELECT art.id, art.title, art.content, art.user_id, art.category_id, art.creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    WHERE art.id = v_id;

END$$

DROP PROCEDURE IF EXISTS `SP_ArticleUpdate`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_ArticleUpdate` (`v_article_id` INT(11), `v_user_id` INT(11), `v_new_title` VARCHAR(255), `v_new_content` TEXT, `v_category_id` INT(11))  BEGIN

    UPDATE articles
    SET title = v_new_title,
        content = v_new_content,
        category_id = v_category_id
    WHERE id = v_article_id
    AND user_id = v_user_id;

END$$

DROP PROCEDURE IF EXISTS `SP_CategoryDelete`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CategoryDelete` (`v_id` INT)  BEGIN 

	DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT; 
    DECLARE categoryinfo VARCHAR(255);
    
    SET message = '';   
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE id = v_id;
    
    IF(exist = 0)THEN

    	SET message = CONCAT('La catégorie ', v_id, ' n''existe pas');

    END IF; 
    
    IF(exist > 0) THEN
        
        SELECT category
        INTO categoryinfo
        FROM categories
        WHERE id = v_id;

        DELETE
        FROM categories
        WHERE id = v_id;
        
        	SET message = CONCAT("La catégorie ",  categoryinfo, " a bien été supprimée");

   END IF; 
   
   SELECT message; 

END$$

DROP PROCEDURE IF EXISTS `SP_CategoryInsert`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CategoryInsert` (`v_category` VARCHAR(255))  BEGIN 

	 DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT; 
    
    SET message = ''; 

   
    
    SELECT COUNT(id)
    INTO exist
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category);

    
    
    IF(exist > 0) THEN 
       SET message = CONCAT('La catégorie ', v_category, ' existe déjà.'); 
    END IF; 

    
       
    IF(exist = 0) THEN 

       INSERT INTO categories (category)
       VALUES(v_category);

       SET message = CONCAT('La catégorie ', v_category ,' a bien été ajoutée.');

    END IF;

    

  	SELECT message;

END$$

DROP PROCEDURE IF EXISTS `SP_CategorySelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CategorySelect` (`v_id` INT)  BEGIN

	SELECT *
    FROM categories cat
    WHERE cat.id = v_id
    AND cat.id <> 1
    OR cat.category <> "Non classé";

END$$

DROP PROCEDURE IF EXISTS `SP_CategoryUpdate`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CategoryUpdate` (`v_id` INT, `v_category` VARCHAR(255))  BEGIN 

	DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT;
    DECLARE doublon SMALLINT; 
    
    SET message = ''; 
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE id = v_id;
    
    IF (exist = 0) THEN

   

    	SET message = CONCAT ('La catégorie ', v_id, ' n''existe pas');

    END IF; 
    
    SELECT COUNT(id)
    INTO doublon
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category)
    AND categories.id <> v_id;
    
    IF(doublon > 0) THEN 

        
    	SET message = CONCAT ('Une catégorie ', v_category, ' existe déjà');


    END IF; 

    IF(message = '') THEN

    

    	UPDATE categories
        SET category = v_category
        WHERE id = v_id;

        
        
        SET message = 'La catégorie a bien été modifiée.';

    END IF;
    
    
    
    SELECT message;

END$$

DROP PROCEDURE IF EXISTS `SP_CategoryWithoutArticlesDelete`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CategoryWithoutArticlesDelete` (`v_id` INT)  BEGIN

    DECLARE exist SMALLINT;
    DECLARE message VARCHAR(512);
    DECLARE categoryinfo VARCHAR(255);

    SET message = '';

    SELECT COUNT(id)
    INTO exist
    FROM categories
    WHERE id = v_id;

    IF (exist = 0) THEN

        SET message = CONCAT("La catégorie ", v_id, " n'existe pas");

    END IF;

    IF (exist > 0) THEN

        SELECT category 
        INTO categoryinfo
        FROM categories
        WHERE id = v_id;

        UPDATE articles
        SET category_id = 1
        WHERE category_id = v_id;

        SET message = CONCAT("La catégorie ", categoryinfo, " a bien été supprimée");

    END IF;

    SELECT message;

END$$

DROP PROCEDURE IF EXISTS `SP_CommentDelete`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CommentDelete` (`v_id` INT(11))  BEGIN

    DELETE
    FROM comments
    WHERE id = v_id;

END$$

DROP PROCEDURE IF EXISTS `SP_CommentInsert`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CommentInsert` (`v_content` TEXT, `v_user_id` INT, `v_article_id` INT)  BEGIN

    DECLARE status_id SMALLINT;

    SET status_id = 1;

    INSERT INTO comments (content, user_id, article_id, status_id, date_publication)
    VALUES
    (v_content, v_user_id, v_article_id, status_id, NOW());

END$$

DROP PROCEDURE IF EXISTS `SP_CommentUpdate`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_CommentUpdate` (`v_id` INT)  BEGIN

    UPDATE comments
    SET status_id = 2
    WHERE id = v_id;
    
END$$

DROP PROCEDURE IF EXISTS `SP_GrantUpdate`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_GrantUpdate` (`v_userId` INT, `v_grantId` INT)  BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existUser SMALLINT;
    DECLARE existGrant SMALLINT;
    
    DECLARE pseudoinfo VARCHAR(255);
    DECLARE privilegeinfo VARCHAR(255);

    SET message = '';

    SELECT COUNT(id)
    INTO existUser 
    FROM users
    WHERE id = v_userId;

    IF (existUser = 0) THEN

        SET message = CONCAT("L'utilisateur ", v_userId, " n'existe pas.");
    
    END IF;

    IF (existUser > 0) THEN 

        SELECT COUNT(id)
        INTO existGrant
        FROM grants
        WHERE id = v_grantId;

        IF (existGrant = 0) THEN

            SET message = CONCAT("Le droit ", v_grantId, " n'existe pas.");

        END IF;

        IF (existGrant > 0) THEN

            UPDATE users
            SET grant_id = v_grantId
            WHERE id = v_userId;

            SELECT pseudo, privilege
            INTO pseudoinfo, privilegeinfo
            FROM users
            INNER JOIN grants ON users.grant_id = grants.id
            WHERE users.id = v_userId;

            SET message = CONCAT("Le droit ", privilegeinfo, " a été attribué à l'utilisateur ", pseudoinfo, ".");

        END IF;

    END IF;

    SELECT message;

END$$

DROP PROCEDURE IF EXISTS `SP_InscriptionInsert`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_InscriptionInsert` (`v_firstname` VARCHAR(255), `v_lastname` VARCHAR(255), `v_pseudo` VARCHAR(255), `v_email` VARCHAR(255), `v_password` VARCHAR(255))  BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;
    DECLARE existeDelete SMALLINT;
    DECLARE v_grantId SMALLINT;
    DECLARE existPseudo SMALLINT;
    
    SET v_grantId = 3;

    SELECT COUNT(id)
    INTO existeDelete
    FROM users
    WHERE pseudo = LOWER('Supprimé');

    IF (existeDelete = 0) THEN

        INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id)
        VALUES (1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), v_grantId);

        SELECT COUNT(id)
        INTO exist
        FROM users
        WHERE email = LOWER(v_email);

        IF (exist > 0) THEN

            SET message = "Un autre utilisateur avec cet email existe déjà.";

            SELECT message;

        END IF;

        SELECT COUNT(id)
        INTO existPseudo
        FROM users
        WHERE pseudo = LOWER(v_pseudo);

        IF (existPseudo > 0) THEN

            SET message = "Un autre utilisateur avec ce pseudo existe déjà.";

            SELECT message;
        
        END IF;
        
        IF (exist = 0 AND existPseudo = 0) THEN

            INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, inscription_date)
            VALUES
            (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, NOW());

            SET message = "Vous êtes bien enregistré, vous pouvez vous connecter.";

            SELECT message;

        END IF;

    END IF;

    IF (existeDelete > 0) THEN

        SELECT COUNT(id)
        INTO exist
        FROM users
        WHERE email = LOWER(v_email);

        IF (exist > 0) THEN

            SET message = "Un autre utilisateur avec cet email existe déjà.";

            SELECT message;

        END IF;

        SELECT COUNT(id)
        INTO existPseudo
        FROM users
        WHERE pseudo = LOWER(v_pseudo);

        IF (existPseudo > 0) THEN

            SET message = "Un autre utilisateur avec ce pseudo existe déjà.";

            SELECT message;
        
        END IF;

        IF (exist = 0 AND existPseudo = 0) THEN

            INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, inscription_date)
            VALUES
            (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, NOW());

            SET message = "Vous êtes bien enregistré, vous pouvez vous connecter.";

            SELECT message;

        END IF;

    END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_MyArticlesSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_MyArticlesSelect` (`v_id` INT)  BEGIN

    SELECT art.id as articleId, art.title, art.content, art.user_id, art.category_id, art.creation_date, cat.id, cat.category, COUNT(com.id) AS number_comments
    FROM articles art
    INNER JOIN categories cat ON art.category_id = cat.id
    INNER JOIN users u ON art.user_id = u.id
    LEFT JOIN comments com ON art.id = com.article_id
    WHERE u.id = v_id
    GROUP BY art.id
    ORDER BY art.creation_date DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_OneCommentSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_OneCommentSelect` (`v_id` INT)  BEGIN

    SELECT *
    FROM comments
    WHERE id = v_id;

END$$

DROP PROCEDURE IF EXISTS `SP_PasswordUpdate`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_PasswordUpdate` (`v_email` VARCHAR(255), `v_password` VARCHAR(255))  BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;

    SELECT COUNT(id)
    INTO exist
    FROM users
    WHERE email = LOWER(v_email);

    IF (exist = 0) THEN 

        SET message = "Cet email n'existe pas.";

        SELECT message;

    END IF;

    IF (exist > 0) THEN

        UPDATE users
        SET password = v_password
        WHERE email = v_email;

        SET message = "Votre mot de passe a correctement été modifié.";
        
        SELECT message;

    END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_SearchSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_SearchSelect` (`v_search` VARCHAR(512))  BEGIN

    SET v_search = CONCAT('%', v_search, '%');

    SELECT DISTINCT art.id AS id_article, art.title, art.content, art.creation_date, art.user_id, u.pseudo, art.category_id, cat.id AS id_category, cat.category
    FROM articles art
    INNER JOIN categories cat ON art.category_id = cat.id
    INNER JOIN users u  ON art.user_id = u.id
    WHERE content LIKE v_search
    OR art.title LIKE v_search
    OR u.pseudo LIKE v_search
    OR cat.category LIKE v_search
    ORDER BY art.creation_date DESC;

END$$

DROP PROCEDURE IF EXISTS `SP_UserByEmailSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_UserByEmailSelect` (`v_email` VARCHAR(255))  BEGIN

    SELECT *
    FROM users
    WHERE email = LOWER(v_email)
    AND id <> 1;

END$$

DROP PROCEDURE IF EXISTS `SP_UserByIdSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_UserByIdSelect` (`v_id` INT(11))  BEGIN

    SELECT *
    FROM users
    WHERE id = v_id
    AND id <> 1;

END$$

DROP PROCEDURE IF EXISTS `SP_UserDelete`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_UserDelete` (`v_id` INT(11))  BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;
    DECLARE pseudoinfo VARCHAR(512);

    SET message = '';

    SELECT COUNT(id)
    INTO exist
    FROM users
    WHERE id = v_id;

    IF (exist = 0) THEN

        SET message = CONCAT("L'utilsateur N° ", v_id, " n'existe pas.");
    
    END IF;

    IF (exist > 0) THEN

        SELECT pseudo
        INTO pseudoinfo
        FROM users
        WHERE id = v_id;

        DELETE
        FROM users
        WHERE id = v_id;

        SET message = CONCAT("L'utilisateur ", pseudoinfo, " a bien été supprimé");

    END IF;

    SELECT message;

END$$

DROP PROCEDURE IF EXISTS `SP_UsersAdminSelect`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_UsersAdminSelect` ()  BEGIN

    SELECT u.id AS userId, u.firstname, u.lastname, u.email, u.pseudo, u.inscription_date, COUNT(art.id) AS number_articles, gr.id AS grantId, gr.privilege
    FROM users u
    LEFT JOIN articles art ON u.id = art.user_id
    INNER JOIN grants gr ON u.grant_id = gr.id
    WHERE u.grant_id <> 1
    AND u.pseudo <> 'Supprimé'
    GROUP BY u.pseudo
    ORDER BY u.inscription_date ASC;

END$$

DROP PROCEDURE IF EXISTS `SP_UserWithoutArticlesCommentsDelete`$$
CREATE DEFINER=`4dm1n1str4teur`@`localhost` PROCEDURE `SP_UserWithoutArticlesCommentsDelete` (`v_id` INT)  BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existUser SMALLINT;
    DECLARE existDelete SMALLINT;
    DECLARE grantId SMALLINT;

    DECLARE pseudoinfo VARCHAR(255);

    SET message = '';
    SET grantId = 2;

    SELECT COUNT(id)
    INTO existDelete
    FROM users
    WHERE LOWER(pseudo) = LOWER('Supprimé');

    IF (existDelete = 0) THEN
        
        INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id)
        VALUES (1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), grantId);

            SELECT COUNT(id)
            INTO existUser
            FROM users
            WHERE id = v_id;

            IF (existUser = 0) THEN

                SET message = CONCAT("L'utilisateur ", v_id ," n'existe pas.");

            END IF;

            IF (existUser > 0) THEN

                SELECT pseudo
                INTO pseudoinfo
                FROM users
                WHERE id = v_id;

                UPDATE comments
                SET user_id = 1
                WHERE user_id = v_id;

                UPDATE articles
                SET user_id = 1
                WHERE user_id = v_id;

                DELETE
                FROM users
                WHERE id = v_id;

                SET message = CONCAT("L'utilisateur ", pseudoinfo, " a bien été supprimé.");

            END IF;

    END IF;

    IF (existDelete > 0) THEN

        SELECT COUNT(id)
        INTO existUser
        FROM users
        WHERE id = v_id;

        IF (existUser = 0) THEN

            SET message = CONCAT("L'utilisateur ", v_id ," n'existe pas.");

        END IF;

        IF (existUser > 0) THEN

            SELECT pseudo
            INTO pseudoinfo
            FROM users
            WHERE id = v_id;

            UPDATE comments
            SET user_id = 1
            WHERE user_id = v_id;

            UPDATE articles
            SET user_id = 1
            WHERE user_id = v_id;

            DELETE
            FROM users
            WHERE id = v_id;

            SET message = CONCAT("L'utilisateur ", pseudoinfo, " a bien été supprimé.");

        END IF;

    END IF;

    SELECT message;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_article` (`user_id`),
  KEY `fk_category_article` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Non classé');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `article_id` int NOT NULL,
  `status_id` int NOT NULL,
  `date_publication` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_com` (`user_id`),
  KEY `fk_article_com` (`article_id`),
  KEY `fk_status_com` (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `grants`
--

DROP TABLE IF EXISTS `grants`;
CREATE TABLE IF NOT EXISTS `grants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `privilege` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `grants`
--

INSERT INTO `grants` (`id`, `privilege`) VALUES
(1, 'Administrateur'),
(2, 'Auteur'),
(3, 'Inscrit');

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `label`) VALUES
(1, 'En attente d\'approbation'),
(2, 'Approuvé');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `grant_id` int NOT NULL,
  `inscription_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grant_id_users` (`grant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `pseudo`, `email`, `password`, `grant_id`, `inscription_date`) VALUES
(1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 3, '2021-11-21 11:14:35');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_category_article` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_article` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_article_com` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_status_com` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_com` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_grant_id_users` FOREIGN KEY (`grant_id`) REFERENCES `grants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
