DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticlesByCategoryTop // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_ArticlesByCategoryTop () -- On créé la procédure. Elle ne prend aucun paramètre, elle doit simplement être appelée.

BEGIN -- Début de l'écriture de la procédure.

-- On écrit la requête. Elle va compter le nombre d'articles de la table articles et les grouper par catégories dans l'ordre du plus grand au plus petit.

    SELECT cat.category, COUNT(art.id) AS Number_of_Articles_by_Category
    FROM articles art
    INNER JOIN categories cat ON art.category_id = cat.id
    GROUP BY cat.category
    ORDER BY Number_of_Articles_by_Category DESC;

END // -- Fin de l'écriture de la procédure.