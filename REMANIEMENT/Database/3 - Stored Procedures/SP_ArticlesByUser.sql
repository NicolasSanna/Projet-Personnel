-- Version avec numéro d'identifiant.

DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticlesByUser // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_ArticlesByUser (v_id INT(11)) -- On créé la procédure, elle prend en paramètre un entier qui est l'identifiant de l'utilisateur venant de la table users.
BEGIN -- Début de l'écriture de la procédure.

-- On lance la requête suivante. Elle va compter le nombre d'articles de l'utilisateur indiqué en variable.
    SELECT users.pseudo, COUNT(articles.id) AS Articles_By_User
    FROM articles 
    INNER JOIN users ON articles.user_id = users.id 
    WHERE users.id = v_id;

END // -- Fin de l'écriture de la procédure.

-- Version avec chaînes de caractères.

DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticlesByPseudo // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_ArticlesByPseudo (v_pseudo VARCHAR(128)) -- On créé la procédure. Elle prend en paramètre une chaîne de caractères qui sera le pseudo de l'utilisateur venant de la table users.
BEGIN -- Début de l'écriture de la procédure.

    --  On lance la requête suivante. Elle va compter le nombre d'articles de l'utilisateur indiqué en variable dans le WHERE. Mais afin d'éviter toute sensibilité à la majuscule, on les paramètre en caractères minuscule grâce à la fonction LOWER() de MySQL.

    SELECT users.pseudo, COUNT(articles.id) AS Articles_By_User
    FROM articles 
    INNER JOIN users ON articles.user_id = users.id 
    WHERE LOWER(users.pseudo) = LOWER(v_pseudo);

END // -- Fin de l'écriture de la procédure.


    