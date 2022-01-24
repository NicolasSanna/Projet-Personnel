DELIMITER //
DROP PROCEDURE IF EXISTS SP_FiveArticlesOrderByDateSelect //
CREATE PROCEDURE SP_FiveArticlesOrderByDateSelect ()
BEGIN

    SELECT art.id, art.title, art.content, art.user_id, art.category_id, DATE_FORMAT(art.creation_date, 'Le %d/%m/%Y à %H:%i') AS creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    ORDER BY art.creation_date DESC
    LIMIT 5;

END //