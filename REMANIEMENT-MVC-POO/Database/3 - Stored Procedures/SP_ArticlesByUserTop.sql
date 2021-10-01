DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticlesByUserTop // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_ArticlesByUserTop () -- On créé la procédure. Elle ne prend aucun paramètre, elle doit simplement être appelée.

BEGIN -- Début de l'écriture de la procédure.

-- On lance la requête. Elle va compter tous les articles de la table articles et les grouper par utilisateurs puis les ranger dans l'ordre du plus grand au plus petit.

    SELECT users.pseudo, COUNT(articles.id) AS Articles_by_User
    FROM articles
    INNER JOIN users ON articles.user_id = users.id
    GROUP BY users.pseudo
    ORDER BY Articles_by_User DESC;

END // -- Fin de l'écriture de la procédure.