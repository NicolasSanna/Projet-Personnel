USE histoire_philosophie;

/*
ALTER TABLE auteur_role DROP FOREIGN KEY fk_aut_role;
ALTER TABLE auteur_role DROP FOREIGN KEY fk_role_aut;
ALTER TABLE article_commentaire DROP FOREIGN KEY fk_com_article;
ALTER TABLE article_commentaire DROP FOREIGN KEY fk_com_auteur;
ALTER TABLE article DROP FOREIGN KEY fk_art_categorie;
ALTER TABLE article DROP FOREIGN KEY fk_art_auteur;
*/

DROP TABLE IF EXISTS categorie;
CREATE TABLE categorie
(
    id_cat INT UNSIGNED NOT NULL AUTO_INCREMENT,
    categorie VARCHAR(128) NOT NULL,
    PRIMARY KEY (id_cat)
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS auteur;
CREATE TABLE auteur
(
    id_aut INT UNSIGNED NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(255) NOT NULL,
    mdp VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    date_creation_compte DATETIME NOT NULL,
    PRIMARY KEY (id_aut)
) ENGINE = InnoDB ;


DROP TABLE IF EXISTS article;
CREATE TABLE article
(
    id_art INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom_article VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    id_aut INT UNSIGNED NULL,
    id_cat INT UNSIGNED NULL,
    date_creation_article DATETIME,
    date_modification_article DATETIME,
    PRIMARY KEY (id_art),
    CONSTRAINT fk_art_auteur
    FOREIGN KEY (id_aut)
        REFERENCES auteur (id_aut),
    CONSTRAINT fk_art_categorie
    FOREIGN KEY (id_cat)
        REFERENCES categorie (id_cat)
) ENGINE = InnoDB ;


DROP TABLE IF EXISTS commentaire;
CREATE TABLE commentaire
(
    id_com INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_art INT UNSIGNED NOT NULL, 
    id_aut INT UNSIGNED NULL,
    commentaire TEXT,
    PRIMARY KEY (id_com),
    CONSTRAINT fk_com_article
    FOREIGN KEY (id_art)
        REFERENCES article (id_art),
    CONSTRAINT fk_com_auteur
    FOREIGN KEY (id_aut)
        REFERENCES auteur (id_aut)
) ENGINE = InnoDB ;

DROP TABLE IF EXISTS role;
CREATE TABLE role
(
    id_role INT UNSIGNED NOT NULL AUTO_INCREMENT,
    grade VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_role)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS auteur_role;
CREATE TABLE auteur_role
(
    id_aut INT UNSIGNED NOT NULL,
    id_role INT UNSIGNED NOT NULL,
    CONSTRAINT fk_aut_role
    FOREIGN KEY (id_aut)
        REFERENCES auteur (id_aut),
    CONSTRAINT fk_role_aut
    FOREIGN KEY (id_role)
        REFERENCES role (id_role)
) ENGINE = InnoDB;