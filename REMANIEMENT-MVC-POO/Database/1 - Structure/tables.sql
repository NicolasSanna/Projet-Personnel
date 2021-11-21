USE huma_scientio;

-- Sur MySQL Workbench, cette fonction permet de ne pas tenir compte des clés étrangères. Mais il faut les réactiver à la fin.
SET foreign_key_checks = 0;

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
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    pseudo VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    grant_id INT NOT NULL,
    inscription_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_grant_id_users
    FOREIGN KEY (grant_id)
    REFERENCES grants (id) ON UPDATE CASCADE ON DELETE CASCADE
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
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    creation_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_user_article
    FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_category_article
    FOREIGN KEY (category_id)
        REFERENCES categories (id) ON DELETE CASCADE ON UPDATE CASCADE
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
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_article_com
    FOREIGN KEY (article_id)
        REFERENCES articles (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_status_com
    FOREIGN KEY (status_id)
        REFERENCES status (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB ;

-- On remet les clés étrangères.
SET foreign_key_checks = 1;