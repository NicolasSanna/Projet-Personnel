-- On indique quelle base de données va recevoir les tables.
USE huma_scientio;

-- Sur MySQL Workbench, cette fonction permet de ne pas tenir compte des clés étrangères. Mais il faut les réactiver à la fin.
-- SET foreign_key_checks = 0;

-- Afin de relancer le script de création de toutes les tables en une seule fois, on commence par supprimer les contraintes des clés étrangères. Sinon, On procède à la création des tables en tant que telles.
ALTER TABLE users DROP CONSTRAINT fk_grant_id_users;
ALTER TABLE articles DROP CONSTRAINT fk_user_article;
ALTER TABLE articles DROP CONSTRAINT fk_category_article;
ALTER TABLE comments DROP CONSTRAINT fk_article_com;
ALTER TABLE comments DROP CONSTRAINT fk_status_com;
ALTER TABLE comments DROP CONSTRAINT fk_user_com;
ALTER TABLE messages DROP CONSTRAINT fk_from_user;
ALTER TABLE messages DROP CONSTRAINT fk_to_user;
ALTER TABLE messages DROP CONSTRAINT fk_message_status_sender;
ALTER TABLE messages DROP CONSTRAINT fk_message_status_receptor;
ALTER TABLE messages DROP CONSTRAINT fk_status_user_sender;

-- On commence la création des tables ici.
DROP TABLE IF EXISTS grants;
CREATE TABLE grants
(
    id INT NOT NULL AUTO_INCREMENT,
    privilege VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS status;
CREATE TABLE status
(
    id INT NOT NULL AUTO_INCREMENT,
    label VARCHAR(128) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128) NOT NULL,
    pseudo VARCHAR(128) NOT NULL UNIQUE,
    email VARCHAR(128) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL,
    grant_id INT NOT NULL,
    grant_label VARCHAR(128) NOT NULL,
    inscription_date DATETIME NOT NULL,
    PRIMARY KEY (id),
        CONSTRAINT fk_grant_id_users
        FOREIGN KEY (grant_id)
            REFERENCES grants (id) ON UPDATE CASCADE
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS categories;
CREATE TABLE categories
(
    id INT NOT NULL AUTO_INCREMENT,
    category VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS articles;
CREATE TABLE articles
(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    image VARCHAR(255) NULL,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    creation_date DATETIME NOT NULL,
    PRIMARY KEY (id),
        CONSTRAINT fk_user_article
        FOREIGN KEY (user_id)
            REFERENCES users (id) ON UPDATE CASCADE,
        CONSTRAINT fk_category_article
        FOREIGN KEY (category_id)
            REFERENCES categories (id) ON UPDATE CASCADE
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS comments;
CREATE TABLE comments
(
    id INT NOT NULL AUTO_INCREMENT,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    status_id INT NOT NULL,
    date_publication DATETIME NOT NULL,
    PRIMARY KEY (id),
        CONSTRAINT fk_user_com
        FOREIGN KEY (user_id)
            REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT fk_article_com
        FOREIGN KEY (article_id)
            REFERENCES articles (id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT fk_status_com
        FOREIGN KEY (status_id)
            REFERENCES status (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS user_status;
CREATE TABLE user_status
(
    id INT NOT NULL AUTO_INCREMENT,
    label VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS message_status;
CREATE TABLE message_status
(
    id INT NOT NULL AUTO_INCREMENT,
    label VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS messages;
CREATE TABLE messages
(
    id INT NOT NULL AUTO_INCREMENT,
    id_message VARCHAR(128) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    from_user_id INT NOT NULL,
    to_user_id INT NOT NULL,
    publication_date DATETIME NOT NULL,
    status_message_sender_id INT NOT NULL,
    status_message_receptor_id INT NOT NULL,
    status_sender_id INT NOT NULL,
    PRIMARY KEY (id),
        CONSTRAINT fk_from_user
        FOREIGN KEY (from_user_id)
            REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT fk_to_user
        FOREIGN KEY (to_user_id)
            REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT fk_message_status_sender
        FOREIGN KEY (status_message_sender_id)
            REFERENCES message_status (id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT fk_message_status_receptor
        FOREIGN KEY (status_message_receptor_id)
            REFERENCES message_status (id) ON UPDATE CASCADE ON DELETE CASCADE,
        CONSTRAINT fk_status_user_sender
        FOREIGN KEY (status_sender_id)
            REFERENCES user_status (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS user_password_change;
CREATE TABLE user_password_change
(
    id INT NOT NULL AUTO_INCREMENT,
    key_change_password VARCHAR(512) NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
        CONSTRAINT fk_user_change
        FOREIGN KEY (user_id)
            REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB ;

-- On remet les clés étrangères.
-- SET foreign_key_checks = 1;